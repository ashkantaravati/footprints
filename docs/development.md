# Development

## Make commands
- `make install`: install Composer and npm dependencies.
- `make dev`: start Laravel and Vite dev servers.
- `make test`: run Pest and Vitest.
- `make lint`: run Pint in check mode, PHPStan, and ESLint.
- `make format`: run Pint and Prettier.
- `make migrate`: run Laravel migrations.
- `make seed`: seed the admin account, sample circle, and local sample users.
- `make build`: build frontend and Android debug APK.
- `make clean`: remove generated dependency/build directories.

## Docker Compose
`docker-compose.yml` is for local development only. It starts MySQL and a PHP CLI server; it is not required for production shared hosting.
