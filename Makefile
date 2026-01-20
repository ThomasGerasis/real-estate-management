DIR := ${CURDIR}

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