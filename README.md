# Footprints

Footprints is a lightweight self-hosted communication platform for families, clubs, communities, and small organizations. The foundation is now a Laravel API, Vue 3 PWA, and Kotlin Android shell while keeping shared PHP/MySQL hosting as the primary deployment target.

## Stack
- Backend: Laravel 12, Eloquent, Sanctum, Scheduler, migrations, validation, resources
- Frontend: Vue 3, Vite, Vue Router, Pinia, Vite PWA plugin
- Android: Kotlin WebView shell with notification/deep-link extension points
- Local only: Docker Compose for PHP/MySQL

## Commands
Run `make install`, `make dev`, `make test`, `make lint`, `make format`, `make migrate`, `make seed`, `make build`, and `make clean` from the repository root.

See `docs/quickstart.md` and `docs/development.md`.
