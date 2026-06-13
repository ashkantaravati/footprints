# Architecture

Footprints uses Laravel 12 rather than custom PHP infrastructure because Laravel 12 supports PHP 8.2+, which is more practical on shared hosts than Laravel 13's newer PHP baseline while remaining actively supported in June 2026. Laravel 13 is tracked as a future upgrade target.

## Bounded domains
- Users authenticate with username and password.
- Circles are groups, including direct-message circles.
- Messages, attachments, memberships, and retention policies are normal tables.
- Footprints are audit/activity records and notification inputs, not the source of truth.

## API
REST endpoints are versioned under `/api/v1` and use Laravel routing, request validation, API resources, Eloquent models, and Sanctum stateful session authentication.

## Retention
Laravel Scheduler runs `footprints:cleanup` hourly. Shared hosts only need one cron entry: `php artisan schedule:run`.
