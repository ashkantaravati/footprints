# VPS Deployment

Use the same Laravel and Vue builds on a VPS. Nginx/Apache should serve `backend/public` for the API and `frontend/dist` for the PWA. Cron should execute `php artisan schedule:run`. Docker Compose may be adapted for VPS, but is optional.
