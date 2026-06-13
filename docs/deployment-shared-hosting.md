# Shared Hosting Deployment

Shared hosting remains a first-class target. Docker, Redis, queues, and WebSockets are not required.

1. Create a MySQL/MariaDB database in cPanel.
2. Upload `backend` outside the public web root where possible.
3. Point the API domain or subdirectory to `backend/public`.
4. Upload the built Vue app from `frontend/dist` to the public PWA location.
5. Edit `backend/.env` with database, URL, session, and Sanctum stateful-domain settings.
6. Run migrations through a one-time SSH command when available, or import a SQL dump generated from the migrations.
7. Configure cPanel cron: `php /home/ACCOUNT/path/backend/artisan schedule:run` every minute or every five minutes.

If the host does not allow SSH, build assets locally, export SQL locally after migrations, and import through phpMyAdmin.
