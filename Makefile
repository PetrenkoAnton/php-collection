.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := inside

inside:
	docker exec -it php-collection /bin/bash
.PHONY: inside

up80:
	docker-compose -f docker-compose-php80.yml up -d
.PHONY: up80

up81:
	docker-compose -f docker-compose-php81.yml up -d
.PHONY: up81

up82:
	docker-compose -f docker-compose-php82.yml up -d
.PHONY: up82

down:
	docker-compose -f docker-compose-php80.yml down
.PHONY: down

php-v:
	docker exec -it php-collection php -v
.PHONY: php -v

test:
	docker exec -it php-collection ./vendor/bin/phpunit
.PHONY: test

composer-test:
	docker exec -it php-collection composer test
.PHONY: composer-test

test-ok:
	docker exec -it php-collection ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it php-collection ./vendor/bin/phpunit --group +
.PHONY: test+
