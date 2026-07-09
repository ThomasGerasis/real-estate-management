DIR := ${CURDIR}

# ─── Dev ──────────────────────────────────────────────────────────────────────
build:
	docker compose -f deploy/dev.docker-compose.yml build --no-cache

run:
	docker compose -p real-estate -f deploy/dev.docker-compose.yml up --detach

exec:
	docker exec -ti real-estate /bin/bash

logs:
	docker logs real-estate -n 1000

db:
	../../SettingsContainers/disaster-recovery-operations/database-manager/database-manager.php --restore --database=real_estate

# ─── Prod ─────────────────────────────────────────────────────────────────────
PROD_COMPOSE = docker compose --env-file deploy/prod.env -f deploy/prod.docker-compose.yml

prod-build:
	docker build \
		--file deploy/prod.Dockerfile \
		--tag real-estate:local \
		.

prod-up:
	$(PROD_COMPOSE) up -d

prod-down:
	$(PROD_COMPOSE) down

prod-logs:
	$(PROD_COMPOSE) logs -f --tail=100

prod-migrate:
	$(PROD_COMPOSE) run --rm app php artisan migrate --force

prod-exec:
	$(PROD_COMPOSE) exec app sh

prod-restart:
	$(PROD_COMPOSE) restart app queue scheduler