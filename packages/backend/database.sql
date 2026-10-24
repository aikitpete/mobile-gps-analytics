-- MySQL / MariaDB schema. Create the database first, e.g.:
--   CREATE DATABASE gps_analytics CHARACTER SET utf8mb4;
-- then: mysql gps_analytics < database.sql

CREATE TABLE IF NOT EXISTS users (
    uid           INT          NOT NULL AUTO_INCREMENT,
    name          VARCHAR(40)  NOT NULL,
    surname       VARCHAR(40)  NOT NULL,
    email         VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    feedback      VARCHAR(500) NOT NULL DEFAULT '',
    category      ENUM('usability_analyst', 'data_analyst', 'data_admin', 'user_admin')
                               NOT NULL DEFAULT 'usability_analyst',
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (uid),
    UNIQUE KEY uq_users_email (email)
) DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS usagedata (
    id                BIGINT       NOT NULL AUTO_INCREMENT,
    uid               INT          NOT NULL,
    latitude          DOUBLE       NOT NULL,
    longitude         DOUBLE       NOT NULL,
    altitude          DOUBLE       NULL,
    accuracy          DOUBLE       NULL,
    battery_supported TINYINT(1)   NOT NULL DEFAULT 0,
    battery_level     DOUBLE       NULL,      -- 0.0 .. 1.0
    battery_charging  TINYINT(1)   NULL,
    notes             VARCHAR(255) NULL,
    recorded_at       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- stored in UTC
    PRIMARY KEY (id),
    KEY idx_usage_uid_time (uid, recorded_at),
    CONSTRAINT fk_usage_user FOREIGN KEY (uid) REFERENCES users (uid) ON DELETE CASCADE
) DEFAULT CHARSET = utf8mb4;
