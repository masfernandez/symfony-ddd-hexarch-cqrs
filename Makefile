.PHONY :

# Setup ————————————————————————————————————————————————————————————————————————

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# Executables: local
SYMFONY_BIN-LOCAL		= /usr/local/bin/symfony
DOCKER-LOCAL   	  		= /usr/local/bin/docker
DOCKER_COMPOSE-LOCAL   	= /usr/local/bin/docker-compose
COMPOSER-LOCAL			= /usr/local/bin/composer
PHP74-LOCAL				= /usr/local/Cellar/php@7.4/7.4.13_1/bin/php
PHP80-LOCAL				= /usr/local/Cellar/php/8.0.0_1/bin/php

# Containers
PHP-C			= docker exec -it docker-symfony-php
COMPOSER-C		= docker run --rm --interactive --volume $(current-dir):/app composer

# Executables: within containers
SYMFONY_BIN		= /usr/bin/symfony
COMPOSER		= /usr/bin/composer

## —— folders —————————————————————————————————————————————————————————————————

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
musiclabel-app-dir := $(current-dir)apps/musiclabelApp
musiclabel-backend := $(musiclabel-app-dir)/backend

debug-paths:
	echo $(current-dir)
	echo $(musiclabel-app-dir)
	echo $(musiclabel-backend)

## —— envs —————————————————————————————————————————————————————————————————

# @todo run these targets within PHP container

dump-dev:
	$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) dev

dump-test:
	$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) test

dump-prod:
	$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) prod

## —— development env ————————————————————————————————————————————————————————
server-start-musiclabel-backend:
	$(SYMFONY_BIN) server:start -d --port=8765 --dir=$(musiclabel-backend)/public

server-stop-musiclabel-backend:
	$(SYMFONY_BIN) server:stop --dir=$(musiclabel-backend)/public

db-create-sqlite:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:database:create --no-interaction --quiet
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:schema:update --force --no-interaction --quiet

db-create:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:database:create --if-not-exists --no-interaction --quiet

db-update:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:schema:update --dump-sql --force --no-interaction --quiet

db-migrate:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:migrations:migrate --all-or-nothing --no-interaction --quiet --allow-no-migration

db-drop:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console doctrine:database:drop --force --quiet

## —— Docker  ————————————————————————————————————————————————————————
up-php:
	$(DOCKER_COMPOSE-LOCAL) -f docker-compose.tests.yml up -d --remove-orphans

up-dev:
	$(DOCKER_COMPOSE-LOCAL) up --remove-orphans -d nginx mysql php rabbitmq redis

up:
	$(DOCKER_COMPOSE-LOCAL) -f docker-compose.yml up --remove-orphans -d

down:
	$(DOCKER_COMPOSE-LOCAL) -f docker-compose.yml down --remove-orphans

## —— Consumer  ————————————————————————————————————————————————————————
supervisord:
	$(PHP-C) supervisord --configuration /etc/supervisor.d/supervisord.ini

## —— Composer ————————————————————————————————————————————————————————————

composer-install:
	$(COMPOSER-C) install

composer-update:
	$(COMPOSER-C) update

## —— PHP tests ————————————————————————————————————————————————————————————

phpcs: up-php
	$(PHP-C) vendor/bin/phpcs -p --colors

phpcs-build: up-php
	$(PHP-C) vendor/bin/phpcbf
	
rector: up-php
	$(PHP-C) vendor/bin/rector process --dry-run

rector-build: up-php
	$(PHP-C) vendor/bin/rector process

# @todo include phpstan in testing
phpstan: up-php
	$(PHP-C) vendor/bin/phpstan analyse src tests

psalm: up-php
	$(PHP-C) vendor/bin/psalm --long-progress --no-cache --no-file-cache
		
phpunit: dump-test up-php
	$(PHP-C) vendor/bin/phpunit \
		--exclude-group='disabled' \
		--log-junit build/test/phpunit/junit.xml tests

phpunit-coverage: up-php
	$(PHP-C) bash -c "\
		export XDEBUG_MODE=coverage && \
		vendor/bin/phpunit \
			--exclude-group='disabled' \
			--log-junit build/test/phpunit/junit.xml \
			--coverage-html build/test/phpunit tests \
		unset XDEBUG_MODE"

behat: dump-test up-php
	$(PHP-C) vendor/bin/behat -f progress

## —— examples  ————————————————————————————————————————————————————————————
create-demo-user:
	$(PHP-C) apps/MusicLabelApp/backend/bin/console app:create-user 'test@email.com' '1234567890'

## —— RUN  ————————————————————————————————————————————————————————————
test: dump-test up-php db-drop db-create-sqlite phpcs rector psalm behat phpunit

dev-start: dump-dev up-dev db-create db-migrate
prod-start: dump-prod up db-create db-migrate

stop: down

# Start supervisord to monitor consumer
prod-start dev-start: supervisord