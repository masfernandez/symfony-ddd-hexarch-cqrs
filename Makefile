.PHONY :

# Setup ————————————————————————————————————————————————————————————————————————

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# Executables: local
SYMFONY_BIN-LOCAL		= /usr/local/bin/symfony
DOCKER-LOCAL   	  		= /usr/local/bin/docker
DOCKER_COMP-LOCAL   	= /usr/local/bin/docker-compose
COMPOSER-LOCAL			= /usr/local/bin/composer
PHP74-LOCAL				= /usr/local/Cellar/php@7.4/7.4.13_1/bin/php
PHP80-LOCAL				= /usr/local/Cellar/php/8.0.0_1/bin/php

# Containers
PHP-C			= docker exec -it docker-symfony-php
COMPOSER-C		= docker run --rm --interactive --volume $(current-dir):/app composer

# Executables: within container
SYMFONY_BIN		= /usr/bin/symfony
COMPOSER		= /usr/bin/composer

## —— folders —————————————————————————————————————————————————————————————————

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
musiclabel-app-dir := $(current-dir)apps/musiclabelApp
musiclabel-bc := $(musiclabel-app-dir)/Catalog
musiclabel-backend := $(musiclabel-bc)/backend

debug-paths:
	echo $(current-dir)
	echo $(musiclabel-app-dir)
	echo $(musiclabel-backend)

## —— envs —————————————————————————————————————————————————————————————————

# @todo run these targets within PHP container

dump-dev:
	@$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) dev

dump-test:
	@$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) test

dump-prod:
	@$(COMPOSER-LOCAL) dump-env --working-dir=$(musiclabel-backend) prod

## —— development env ————————————————————————————————————————————————————————
server-start-musiclabel-backend:
	@$(SYMFONY_BIN) server:start -d --port=8765 --dir=$(musiclabel-backend)/public

server-stop-musiclabel-backend:
	@$(SYMFONY_BIN) server:stop --dir=$(musiclabel-backend)/public

db-create:
	@$(PHP-C) apps/MusicLabelApp/Catalog/backend/bin/console doctrine:database:create --no-interaction --quiet
	@$(PHP-C) apps/MusicLabelApp/Catalog/backend/bin/console doctrine:schema:create --no-interaction --quiet

db-drop:
	@$(PHP-C) apps/MusicLabelApp/Catalog/backend/bin/console doctrine:database:drop --force --quiet

## —— Docker  ————————————————————————————————————————————————————————
up-php:
	@$(DOCKER_COMP-LOCAL) -f docker-compose.tests.yml up -d --remove-orphans 2>/dev/null

up-dev:
	@$(DOCKER_COMP-LOCAL) up --remove-orphans -d nginx mysql php rabbitmq 2>/dev/null

up:
	@$(DOCKER_COMP-LOCAL) -f docker-compose.yml up --remove-orphans -d 2>/dev/null

down:
	@$(DOCKER_COMP-LOCAL) -f docker-compose.yml down --remove-orphans 2>/dev/null

## —— Comsumer  ————————————————————————————————————————————————————————
# @todo remove warnign message when starting supervisor (--silent 2>/dev/null does not work)
supervisord:
	@$(PHP-C) supervisord --silent 2>/dev/null

## —— Composer ————————————————————————————————————————————————————————————

composer-install:
	$(COMPOSER-C) install --no-cache

composer-update:
	$(COMPOSER-C) update --no-cache

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
		
phpunit: up-php
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

behat: up-php
	$(PHP-C) vendor/bin/behat -f progress

## —— RUN  ————————————————————————————————————————————————————————————
test: dump-test up-php db-create phpcs rector psalm behat phpunit

dev-start: dump-dev up-dev db-create
prod-start: dump-prod up db-create

stop: down

# Start supervidor to monitor comsumer
prod-start dev-start: supervisord