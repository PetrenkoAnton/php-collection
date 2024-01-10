.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := inside

inside:
	docker exec -it php-collection /bin/bash
.PHONY: inside

up:
	docker-compose up -d
.PHONY: up

down:
	docker-compose down
.PHONY: down

test-ok:
	docker exec -it php-collection ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it php-collection ./vendor/bin/phpunit --group +
.PHONY: +
