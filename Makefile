-include ./docker/.env

.SILENT:
.NOTPARALLEL:

.DEFAULT_GOAL := inside

init:
	cp ./docker/.env.example ./docker/.env && echo Created ./docker/.env
.PHONY: init

inside:
	docker exec -it ${CONTAINER_NAME} /bin/bash
.PHONY: inside

up80:
	docker-compose -f docker/docker-compose-php80.yml up -d
.PHONY: up80

up81:
	docker-compose -f docker/docker-compose-php81.yml up -d
.PHONY: up81

up82:
	docker-compose -f docker/docker-compose-php82.yml up -d
.PHONY: up82

up83:
	docker-compose -f docker/docker-compose-php83.yml up -d
.PHONY: up83

down:
	docker stop ${CONTAINER_NAME} && docker rm ${CONTAINER_NAME}
.PHONY: down

php-v:
	docker exec -it ${CONTAINER_NAME} php -v
.PHONY: php-v

v:
	docker exec -it ${CONTAINER_NAME} cat VERSION
.PHONY: v

test:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/phpunit
.PHONY: test

test-c:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/phpunit --coverage-text
.PHONY: test-c

test-ok:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/phpunit --group +
.PHONY: test+

psalm:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/psalm --show-info=true --no-cache
.PHONY: psalm

phpcs:
	docker exec -it ${CONTAINER_NAME} ./vendor/bin/phpcs -v
.PHONY: phpcs
