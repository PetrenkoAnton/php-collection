.SILENT:
.NOTPARALLEL:

.DEFAULT_GOAL := inside

inside:
	docker exec -it php-collection /bin/bash
.PHONY: inside

up80:
	docker-compose -f docker/php80/docker-compose.yml up -d
.PHONY: up80

up81:
	docker-compose -f docker/php81/docker-compose.yml up -d
.PHONY: up81

up82:
	docker-compose -f docker/php82/docker-compose.yml up -d
.PHONY: up82

up83:
	docker-compose -f docker/php83/docker-compose.yml up -d
.PHONY: up83

down:
	docker stop php-collection && docker rm php-collection
.PHONY: down

php-v:
	docker exec -it php-collection php -v
.PHONY: php -v

v:
	docker exec -it php-collection cat VERSION
.PHONY: v

test:
	docker exec -it php-collection ./vendor/bin/phpunit
.PHONY: test

test-c:
	docker exec -it php-collection ./vendor/bin/phpunit --coverage-text
.PHONY: test-c

composer-test:
	docker exec -it php-collection composer test
.PHONY: composer-test

composer-test-c:
	docker exec -it php-collection composer test-c
.PHONY: composer-test-c

test-ok:
	docker exec -it php-collection ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it php-collection ./vendor/bin/phpunit --group +
.PHONY: test+

psalm:
	docker exec -it php-collection ./vendor/bin/psalm --show-info=true
.PHONY: psalm

psalm-t:
	docker exec -it php-collection ./vendor/bin/psalm --config=./tests/psalm.xml --show-info=true
.PHONY: psalm-t

composer-psalm:
	docker exec -it php-collection composer psalm
.PHONY: composer-psalm

composer-psalm-t:
	docker exec -it php-collection composer psalm-t
.PHONY: composer-psalm-t