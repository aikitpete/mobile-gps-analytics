#!/usr/bin/env bash
# Smoke tests: unit tests for the analysis functions plus an end-to-end run against PHP's built-in
# server with a throw-away SQLite database. Requires php (with pdo_sqlite) and curl.
set -euo pipefail
cd "$(dirname "$0")/.."

php tests/analysis_test.php

TMP="$(mktemp -d)"
PORT="${PORT:-8089}"
trap 'kill "${SERVER_PID:-}" 2>/dev/null || true; rm -rf "$TMP"' EXIT
export DB_DSN="sqlite:$TMP/test.sqlite"
php -r '$p = new PDO(getenv("DB_DSN")); $p->exec(file_get_contents("tests/schema.sqlite.sql"));'

php -S "127.0.0.1:$PORT" -t public >"$TMP/server.log" 2>&1 &
SERVER_PID=$!
for _ in $(seq 1 30); do curl -s "http://127.0.0.1:$PORT/index.php" >/dev/null && break; sleep 0.2; done

BASE="http://127.0.0.1:$PORT"
JAR="$TMP/jar"
fail() { echo "FAIL: $1"; exit 1; }
pass() { echo "ok   $1"; }
token() { curl -s -b "$JAR" -c "$JAR" "$BASE/index.php?action=$1" | sed -n 's/.*data-csrf="\([^"]*\)".*/\1/p'; }
code() { curl -s -o /dev/null -w '%{http_code}' "$@"; }

[ "$(code "$BASE/api.php?action=list")" = 401 ] && pass "API requires login" || fail "API requires login"
[ "$(code "$BASE/index.php?action=data")" = 302 ] && pass "protected page redirects" || fail "protected page redirects"
[ "$(code -X POST "$BASE/index.php?action=signup" -d x=1)" = 403 ] && pass "form without CSRF token rejected" || fail "csrf"

T="$(token signup)"
curl -s -b "$JAR" -c "$JAR" "$BASE/index.php?action=signup" \
    --data-urlencode "csrf=$T" -d "name=Test&surname=User&email=test@example.com&password=correct-horse&password2=correct-horse" \
    | grep -q "Registration successful" && pass "sign up" || fail "sign up"

T="$(token signin)"
[ "$(code -b "$JAR" -c "$JAR" "$BASE/index.php?action=signin" --data-urlencode "csrf=$T" -d "email=test@example.com&password=wrong-password")" = 200 ] \
    && pass "wrong password stays on form" || fail "wrong password"
[ "$(code -b "$JAR" -c "$JAR" "$BASE/index.php?action=signin" --data-urlencode "csrf=$T" -d "email=test@example.com&password=correct-horse")" = 302 ] \
    && pass "sign in" || fail "sign in"

T="$(token collect)"
for lvl in 0.80 0.79 0.78; do
    [ "$(code -b "$JAR" -X POST "$BASE/api.php?action=collect" -H "Content-Type: application/json" -H "X-CSRF-Token: $T" \
        -d "{\"latitude\":55.70,\"longitude\":13.19,\"accuracy\":12,\"battery_supported\":true,\"battery_level\":$lvl,\"battery_charging\":false}")" = 201 ] \
        || fail "collect sample"
done
pass "collect samples"
[ "$(code -b "$JAR" -X POST "$BASE/api.php?action=collect" -H "Content-Type: application/json" -H "X-CSRF-Token: $T" -d '{"latitude":999,"longitude":13}')" = 422 ] \
    && pass "invalid latitude rejected" || fail "validation"
[ "$(code -b "$JAR" -X POST "$BASE/api.php?action=collect" -H "Content-Type: application/json" -d '{"latitude":55,"longitude":13}')" = 403 ] \
    && pass "collect without CSRF token rejected" || fail "collect csrf"

curl -s -b "$JAR" "$BASE/api.php?action=list" | grep -q '"total":3' && pass "list returns own rows" || fail "list"
curl -s -b "$JAR" "$BASE/index.php?action=analyze" | grep -q "Test User" && pass "analysis page renders" || fail "analysis page"
[ "$(code -b "$JAR" -X POST "$BASE/api.php?action=delete" -H "Content-Type: application/json" -H "X-CSRF-Token: $T" -d '{"id":1}')" = 403 ] \
    && pass "delete needs admin role" || fail "delete authz"
[ "$(code -b "$JAR" "$BASE/api.php?action=locations&uid=999")" = 403 ] \
    && pass "other users' locations are forbidden" || fail "locations authz"

php -r '$p = new PDO(getenv("DB_DSN")); $p->exec("UPDATE users SET category = \"data_admin\"");'
# The role is read at sign-in, so sign in again after the promotion.
T="$(token signin)"
curl -s -o /dev/null -b "$JAR" -c "$JAR" "$BASE/index.php?action=signin" --data-urlencode "csrf=$T" -d "email=test@example.com&password=correct-horse"
T="$(token collect)"
curl -s -b "$JAR" -X POST "$BASE/api.php?action=delete" -H "Content-Type: application/json" -H "X-CSRF-Token: $T" -d '{"id":1}' | grep -q '"deleted":1' \
    && pass "admin can delete" || fail "admin delete"

# SQL metacharacters in the email are data, not code.
T="$(token signin)"
[ "$(code -b "$JAR" -c "$JAR" "$BASE/index.php?action=signin" --data-urlencode "csrf=$T" --data-urlencode "email=' OR '1'='1" -d "password=x")" = 200 ] \
    && pass "SQL injection attempt does not sign in" || fail "sql injection"

echo "All smoke tests passed."
