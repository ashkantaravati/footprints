# Shared Hosting Deployment

Footprints is designed for cPanel-style PHP hosting with no Node.js, Docker, queues, or WebSockets.

## Steps
1. Create a MySQL/MariaDB database and user in cPanel.
2. Import `sql/schema.sql` through phpMyAdmin.
3. Upload files via FTP or cPanel File Manager.
4. Edit `backend/config/config.php` with the database credentials and deployment URL.
5. Ensure PHP 8.x is selected.
6. Open `/admin/index.php`, log in with the seeded admin account, create real users, and disable/reset accounts as needed.

## Cron cleanup
Configure cPanel Cron Jobs to run hourly or daily:

```sh
php /home/YOUR_ACCOUNT/public_html/backend/jobs/cleanup.php
```

The cleanup job expires sessions and soft-deletes messages or attachments whose retention date has passed.

## Android wrapper
Open `/android` in Android Studio, change `footprints_url` in `android/app/src/main/res/values/strings.xml`, and build the APK.
