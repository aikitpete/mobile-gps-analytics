-- SQLite twin of ../database.sql, used only by the smoke tests.
CREATE TABLE users (
    uid           INTEGER PRIMARY KEY AUTOINCREMENT,
    name          TEXT NOT NULL,
    surname       TEXT NOT NULL,
    email         TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    feedback      TEXT NOT NULL DEFAULT '',
    category      TEXT NOT NULL DEFAULT 'usability_analyst',
    created_at    TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE usagedata (
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    uid               INTEGER NOT NULL REFERENCES users (uid) ON DELETE CASCADE,
    latitude          REAL NOT NULL,
    longitude         REAL NOT NULL,
    altitude          REAL,
    accuracy          REAL,
    battery_supported INTEGER NOT NULL DEFAULT 0,
    battery_level     REAL,
    battery_charging  INTEGER,
    notes             TEXT,
    recorded_at       TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
