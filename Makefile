.PHONY: init-dev test

DC=docker-compose
DE=docker-compose exec -T app

ALIAS?=alias
Darwin:
	sudo ifconfig lo0 $(ALIAS) $(shell awk '$$1 ~ /^DEV_IP/' .env | sed -e "s/^DEV_IP=//")
Linux:
	@echo 'skipping ...'
.lo0-up:
	-@make `uname`
.lo0-down:
	-@make `uname` ALIAS='-alias'
.env:
	sed -e "s/{DEV_UID}/$(shell if [ "$(shell uname)" = "Linux" ]; then echo $(shell id -u); else echo '1001'; fi)/g" \
		-e "s/{DEV_GID}/$(shell if [ "$(shell uname)" = "Linux" ]; then echo $(shell id -g); else echo '1001'; fi)/g" \
		.env.dist > .env; \

# Docker
docker-up-force: .env .lo0-up
	$(DC) pull
	$(DC) up -d --force-recreate --remove-orphans

docker-down-clean: .env .lo0-down
	$(DC) down -v

docker-compose.ci.yml:
	# Comment out any port forwarding
	sed -r 's/^(\s+ports:)$$/#\1/g; s/^(\s+- \$$\{DEV_IP\}.*)$$/#\1/g' docker-compose.yml > docker-compose.ci.yml

# Composer
composer-install:
	$(DE) composer install
	$(DE) composer update --dry-run roave/security-advisories

composer-update:
	$(DE) composer update
	$(DE) composer normalize
	$(DE) composer update --dry-run roave/security-advisories

composer-outdated:
	$(DE) composer outdated

# Console
clear-cache:
	$(DE) rm -rf var

# App dev
init-dev: docker-up-force composer-install

phpcodesniffer:
	$(DE) ./vendor/bin/phpcs --parallel=$$(nproc) --standard=./ruleset.xml src tests

phpcodesnifferfix:
	$(DE) ./vendor/bin/phpcbf --parallel=$$(nproc) --standard=./ruleset.xml src tests

phpstan:
	$(DE) ./vendor/bin/phpstan analyse -c ./phpstan.neon -l 8 src tests

phpunit:
	$(DE) ./vendor/bin/paratest -c ./vendor/hanaboso/php-check-utils/phpunit.xml.dist -p $$(nproc) --runner=WrapperRunner tests/Unit

phpcontroller:
	$(DE) ./vendor/bin/paratest -c ./vendor/hanaboso/php-check-utils/phpunit.xml.dist -p $$(nproc)--runner=WrapperRunner tests/Controller

phpcoverage:
	$(DE) ./vendor/bin/paratest -c ./vendor/hanaboso/php-check-utils/phpunit.xml.dist -p $$(nproc) --coverage-html var/coverage --cache-directory var/cache/coverage --coverage-filter src tests

phpcoverage-ci:
	$(DE) ./vendor/hanaboso/php-check-utils/bin/coverage.sh -p $$(nproc)

test: docker-up-force composer-install fasttest

fasttest: clear-cache phpcodesniffer phpstan phpunit phpcontroller phpcoverage-ci
