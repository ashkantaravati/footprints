# Migration Plan from Skeleton

1. Replace custom PHP front controller, PDO wrapper, and hand-rolled auth with Laravel routing, Eloquent, sessions, validation, and Sanctum.
2. Rename business-facing groups to Circles while preserving direct and group messaging concepts.
3. Import existing SQL data into Laravel tables with a one-off migration script if needed.
4. Rebuild the PWA as Vue 3 routes/stores against `/api/v1`.
5. Replace the Java Android wrapper with Kotlin while keeping WebView reuse for the initial release.
6. Move cron from `backend/jobs/cleanup.php` to Laravel Scheduler and `footprints:cleanup`.
