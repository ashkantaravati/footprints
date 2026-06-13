# Quickstart

1. Copy `backend/.env.example` to `backend/.env` and set database credentials.
2. From `backend`, run `composer install`, `php artisan key:generate`, `php artisan migrate --seed`.
3. From `frontend`, run `npm install` and `npm run build`.
4. Point the web root to `backend/public` for the API and upload `frontend/dist` as the PWA.
5. Log in with `admin` / `ChangeMeNow123!` and change the password.

For local development, `make install`, `make migrate`, `make seed`, and `make dev` provide the fastest path.
