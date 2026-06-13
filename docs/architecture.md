# Architecture

## Event stream: Footprints
Every important action records an immutable row in `footprints`: message creation, group creation, membership changes, upload events, notifications, and audit-relevant user events.

## Backend
The backend is plain PHP 8 with a tiny custom bootstrap. `backend/public/index.php` routes requests to `backend/api/index.php`. Persistent state is stored in MySQL/MariaDB.

## Authentication
Authentication uses username and password only. Passwords are hashed with PHP `password_hash`, which uses bcrypt by default unless the PHP runtime changes the default. Long-lived sessions store only a SHA-256 token hash in the database. Cookies are HttpOnly and SameSite=Lax.

## Messaging
Direct messages can be represented as one-to-one groups. Group messages are paginated by message id. The PWA polls `/poll` every few seconds and refreshes active group history when new footprints arrive.

## Retention
Messages and attachments include `retention_until`. Shared-hosting compatible cron runs `backend/jobs/cleanup.php`, which uses SQL updates/deletes and requires no worker daemon.

## Production notes
Keep deployments small: up to about 100 users and around 20 active concurrent users. Use HTTPS so session cookies are secure in browsers. Avoid storing secrets in web-accessible documentation.
