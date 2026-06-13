# Footprints Quickstart

Footprints is a lightweight self-hosted communication system for small teams. It uses PHP 8, MySQL/MariaDB, a vanilla JavaScript PWA, and an Android WebView wrapper.

## Local/shared-hosting setup
1. Upload the repository contents to your hosting account.
2. Import `sql/schema.sql` in phpMyAdmin.
3. Copy `backend/config/config.example.php` to `backend/config/config.php` and set database credentials plus your base URL.
4. Visit `/frontend/src/index.html` and log in as `admin` with `ChangeMeNow123!`.
5. Change the admin password immediately from the app or reset it from `/admin`.

## Important URLs
- PWA: `/frontend/src/index.html`
- API front controller: `/backend/public/index.php?route=...`
- Admin panel: `/admin/index.php`
- Cleanup cron script: `/backend/jobs/cleanup.php`
