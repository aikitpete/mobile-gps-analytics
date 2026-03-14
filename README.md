# mobile-gps-tracking

A web-backed GPS tracking and analysis project focused on collecting location traces and measuring the battery impact of mobile tracking.

## What it does
This repository combines data collection, storage, visualization, and analysis for mobile GPS usage.

It includes:

- PHP endpoints for collection and retrieval,
- SQL schema setup,
- user/session/auth pages,
- usage and analysis pages,
- JavaScript/CSS assets,
- a Python script for elevation chart generation.

## Repository structure
Main files/folders include:

- `collect.php` – data intake endpoint
- `retrievedata.php`, `data.php`, `usagedata.php` – retrieval and reporting
- `analyze.php`, `usage.php`, `view.php` – analysis / visualization views
- `database.sql` – schema
- `ElevationChartCreator.py` – elevation visualization helper
- `css/`, `js/` – frontend assets

## Tech
- PHP
- SQL
- JavaScript
- Python

## Why this repo is interesting
This is more than a simple tracker. It shows full-stack thinking around:
- sensor/mobile data ingestion,
- user accounts and sessions,
- storage design,
- usage analytics,
- performance/battery trade-off analysis.
