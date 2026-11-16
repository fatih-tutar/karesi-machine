# TradeOps

Commercial operations hub: sales, purchasing, accounting, and multi-business management.

Greenfield Laravel rebuild of the legacy Karesi Makine Core PHP app. PostgreSQL-backed; additional business lines can later mount via subdomain.

## Stack

- Laravel 13
- Docker Compose: PHP-FPM, Nginx, PostgreSQL 16, pgAdmin
- Railway deploy via `Dockerfile.railway`

## Requirements

- Docker Desktop (or Docker Engine + Compose v2)
- Node.js 22+ optional (Vite builds; or use a Node Docker image)

## Quick start

```bash
cp .env.example .env

docker compose build
docker compose up -d

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate

# Frontend assets (optional for now):
# npm install && npm run build
```

- App: **http://localhost:8090**
- pgAdmin: **http://localhost:8091**
  - Email: `admin@example.com`
  - Password: `secret`
  - Server host: `postgres` / port `5432` / user `tradeops` / password `secret` / db `tradeops`

Ports differ from StockPilot (`8080`/`8081`/`5432`) so both can run side by side.

### Useful commands

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker
docker compose logs -f
docker compose down
```

## Project layout (Docker)

| Service | Role | Port |
|---------|------|------|
| `nginx` | Web server | `8090` → 80 |
| `app` | PHP 8.4 FPM | — |
| `postgres` | PostgreSQL 16 | `5433` (host) |
| `pgadmin` | DB UI | `8091` → 80 |

`.env`, `vendor/`, and `node_modules/` are not committed.
