# Footprints

A production-oriented starter monorepo for a lightweight, self-hosted communication system that runs on cheap PHP/MySQL shared hosting.

## Structure
- `backend/` plain PHP API, auth, core services, config, and cron jobs
- `frontend/` installable vanilla JS PWA with service worker caching and polling
- `admin/` simple PHP backoffice for users, groups, and settings
- `android/` native Android WebView wrapper that reuses the PWA
- `sql/` schema and migration placeholder
- `docs/` quickstart, shared-hosting deployment, and architecture notes

See `docs/quickstart.md` to deploy in about 30 minutes.
