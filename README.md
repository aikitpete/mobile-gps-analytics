# mobile-gps-tracker

A full-stack GPS tracking and analysis platform combining a mobile iOS tracker with a web-based backend for storing, analyzing, and visualizing location traces.

The project explores how mobile GPS data can be collected, stored, and analyzed while also measuring the battery and performance impact of continuous location tracking.

---

## Overview

This repository is organized as a small monorepo containing two main packages:

- **`packages/mobile-ios`** – iOS GPS tracking application that records location data during activities such as bike rides.
- **`packages/backend`** – web backend responsible for ingesting, storing, and analyzing GPS traces.

Together they form an **end‑to‑end telemetry pipeline**:

1. The iOS app collects GPS coordinates and activity data.
2. Data is sent to backend endpoints.
3. The backend stores traces in a database.
4. Analysis tools visualize usage patterns and elevation data.

---

## Repository Structure

```
packages/
│
├─ backend/
│  ├─ collect.php                # Data ingestion endpoint
│  ├─ retrievedata.php           # Data retrieval API
│  ├─ data.php                   # Data access layer
│  ├─ usagedata.php              # Usage statistics queries
│  ├─ analyze.php                # Data analysis views
│  ├─ usage.php                  # Usage analytics dashboard
│  ├─ view.php                   # Visualization interface
│  ├─ database.sql               # Database schema
│  ├─ ElevationChartCreator.py   # Elevation profile generation
│  ├─ css/                       # UI styles
│  └─ js/                        # Frontend scripts
│
└─ mobile-ios/
   ├─ BikeTracker.xcodeproj      # Xcode project
   ├─ BikeTracker/               # iOS application source
   └─ BikeTrackerTests/          # Unit tests
```

---

## Backend (packages/backend)

The backend provides the web infrastructure for receiving and analyzing GPS traces.

Key responsibilities:

- Accept incoming GPS data from mobile devices
- Persist location traces in a relational database
- Provide APIs for retrieving and analyzing activity data
- Render usage statistics and activity visualizations

Core components:

- **PHP ingestion endpoints** for receiving GPS data
- **SQL schema (`database.sql`)** defining the storage model
- **Analytics pages** for exploring collected traces
- **Elevation analysis** using the Python script `ElevationChartCreator.py`

---

## Mobile App (packages/mobile-ios)

The iOS application records GPS coordinates during activities such as cycling.

Key capabilities:

- Capture location updates from the device GPS
- Record activity sessions
- Send GPS data to backend endpoints
- Provide a simple interface for tracking rides

The mobile application is implemented as a native iOS project using Xcode.

---

## Technologies

Backend:

- PHP
- SQL
- JavaScript
- Python (data visualization / elevation charts)

Mobile:

- Swift / Objective‑C based iOS application
- Xcode project structure

---

## Why this project is interesting

This project demonstrates **end‑to‑end telemetry engineering**, covering:

- mobile sensor data collection
- API-based data ingestion
- backend data storage design
- analytics dashboards
- elevation and activity analysis
- mobile battery impact considerations

It represents an early exploration of **mobile telemetry pipelines**, which are now common in fitness tracking, IoT, and location‑based applications.

---

## Possible Extensions

Potential future improvements could include:

- replacing the PHP backend with a modern API framework
- adding map visualizations using Leaflet or Mapbox
- integrating time-series storage for GPS traces
- exporting ride data in GPX format
- adding battery usage instrumentation for GPS sampling strategies
