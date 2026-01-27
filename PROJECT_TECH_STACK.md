# Project Tech Stack & Versions

This document outlines the technologies, frameworks, and versions currently used in the `laravel-nailsting` project.

## Backend (PHP/Laravel)

- **Framework**: Laravel Framework `^12.0` (Bleeding Edge/Dev)
- **Language**: PHP `^8.2`
- **Authentication**:
    - `laravel/breeze`: `^2.3` (likely used for scaffolding)
    - `php-open-source-saver/jwt-auth`: `^2.8` (JWT Authentication for APIs)
- **Media & Storage**:
    - `spatie/laravel-medialibrary`: `^11.0.0`
    - `league/flysystem-aws-s3-v3`: `^3.0` (Used for MinIO/S3 Integration)
- **Testing**:
    - `pestphp/pest`: `^3.8` (Testing Framework)
    - `pestphp/pest-plugin-laravel`: `^3.2`

## Frontend (JavaScript/CSS)

- **Build Tool**: Vite `^7.0.7`
    - Plugin: `laravel-vite-plugin`: `^2.0.0`
- **CSS Framework**: Tailwind CSS
    - `tailwindcss`: `^3.1.0` (Core)
    - `@tailwindcss/vite`: `^4.0.0` (Vite Integration - Tailwind 4 Alpha/Beta)
    - `@tailwindcss/forms`: `^0.5.2`
- **JavaScript Library**: Alpine.js `^3.4.2` (Lightweight reactivity)
- **HTTP Client**: Axios `^1.11.0`
- **Legacy/Specific Build Tools**: Gulp (`gulp`, `gulp-sass`, `gulp-concat`) is present in devDependencies, though `npm run build` defaults to Vite.

## Database & Infrastructure

- **Default Database**: SQLite (Configured as default in `config/database.php`)
    - Also supports: MySQL, MariaDB, PostgreSQL, SQL Server.
- **Object Storage**: MinIO (Inferred from S3 driver and project documentation `MINIO_INTEGRATION.md`).
- **Containerization**: Docker (`docker-compose.yml` present).

## Project Configuration Files

- **Dependencies**: `composer.json`
- **JS Dependencies**: `package.json`
- **Build Config**: `vite.config.js`
- **Tailwind Config**: `tailwind.config.js` (`export default` ESM format)
- **Database Config**: `config/database.php`
