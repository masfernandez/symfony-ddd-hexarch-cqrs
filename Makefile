.PHONY :

RED=\033[0;31m
GREEN=\033[0;32m
ORANGE=\033[0;33m
NC=\033[0m

# Setup ————————————————————————————————————————————————————————————————————————

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# Executables: local
DOCKER-EXEC   	  		= docker
DOCKER_COMPOSE-EXEC   	= docker-compose # todo: Docker Compose is now in the Docker CLI

## —— folders —————————————————————————————————————————————————————————————————

current-dir 		:= $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
musiclabel-app-dir 	:= $(current-dir)apps/musiclabelApp
musiclabel-backend 	:= $(musiclabel-app-dir)/backend

debug-paths:
	echo $(current-dir)
	echo $(musiclabel-app-dir)
	echo $(musiclabel-backend)

## —— envs —————————————————————————————————————————————————————————————————
#@todo improve envs generation and delete app:dump-env command
dump-dev:
	./console app:dump-env dev

dump-test:
	./console app:dump-env test

dump-prod:
	./console app:dump-env prod

## —— development env ————————————————————————————————————————————————————————
db-create-sqlite:
	./console doctrine:database:create --no-interaction --quiet
	./console doctrine:schema:update --force --no-interaction --quiet

db-create:
	./console doctrine:database:create --if-not-exists --no-interaction --quiet

db-update:
	./console doctrine:schema:update --dump-sql --force --no-interaction --quiet

db-migrate:
	./console doctrine:migrations:migrate --all-or-nothing --no-interaction --quiet --allow-no-migration

db-drop:
	./console doctrine:database:drop --force --quiet

clean-logs:
	truncate -s 0 var/log/symfony/MusicLabelApp/*.log
	truncate -s 0 var/log/nginx/*.log

## —— Docker  ————————————————————————————————————————————————————————
up-dev:
	$(DOCKER_COMPOSE-EXEC) up -d --remove-orphans

up-test:
	$(DOCKER_COMPOSE-EXEC) -f docker-compose.tests.yml up -d --remove-orphans

up:
	$(DOCKER_COMPOSE-EXEC) -f docker-compose.yml up -d --remove-orphans

stop:
	$(DOCKER_COMPOSE-EXEC) -f docker-compose.yml stop

down:
	$(DOCKER_COMPOSE-EXEC) -f docker-compose.yml down --remove-orphans

logs:
	$(DOCKER_COMPOSE-EXEC) -f docker-compose.yml logs -f

## —— Consumer  ————————————————————————————————————————————————————————
supervisord:
	./php supervisord --configuration /etc/supervisor.d/supervisord.ini

## —— Composer ————————————————————————————————————————————————————————————

composer-install:
	@./php composer install

composer-update:
	@./php composer update

## —— PHP tests ————————————————————————————————————————————————————————————

phpcs: up-test phpcs-testsuite
phpcs-testsuite:
	./php vendor/bin/phpcs -p --colors --extensions=php --standard=PSR12  src tests

phpcs-build: up-test phpcs-build-testsuite
phpcs-build-testsuite:
	./php vendor/bin/phpcbf -p --colors --extensions=php --standard=PSR12 src tests

rector: up-test rector-testsuite
rector-testsuite:
	./php vendor/bin/rector process --dry-run --clear-cache

rector-build: up-test rector-build-testsuite
rector-build-testsuite:
	./php vendor/bin/rector process

phpstan: up-test phpstan-testsuite
phpstan-testsuite:
	./php vendor/bin/phpstan analyse -c phpstan.neon

psalm: up-test psalm-testsuite
psalm-testsuite:
	./php vendor/bin/psalm --long-progress --no-cache --no-file-cache

phpunit: up-test dump-test db-drop db-create-sqlite phpunit-testsuite
phpunit-testsuite:
	./php vendor/bin/phpunit \
		--exclude-group='disabled' \
		--log-junit build/test/phpunit/junit.xml tests

phpunit-coverage: up-test dump-test db-drop db-create-sqlite phpunit-coverage-testsuite
phpunit-coverage-testsuite:
	rm -rf build/tests/phpunit
	#@todo ./php does not work here
	docker exec -it docker-symfony-php bash -c "\
		export XDEBUG_MODE=coverage && \
		vendor/bin/phpunit \
			--exclude-group='disabled' \
			--log-junit build/test/phpunit/junit.xml \
			--coverage-html build/test/phpunit tests \
		unset XDEBUG_MODE";
	@printf "\n${ORANGE}--> ${NC}${GREEN}Coverage report build at path:${NC} build/test/phpunit\n\n";

behat: up-test dump-test db-drop db-create-sqlite behat-testsuite
behat-testsuite:
	./php vendor/bin/behat -f progress

## —— elastic  ————————————————————————————————————————————————————————————
filebeat-dashboards:
	$(DOCKER-EXEC) exec -it docker-symfony-filebeat filebeat setup --dashboards

## —— examples  ————————————————————————————————————————————————————————————
create-demo-user:
	./console app:create-user 'test@email.com' '1234567890'

## —— RUN  ————————————————————————————————————————————————————————————
test: up-test dump-test db-drop db-create-sqlite rector-testsuite phpcs-testsuite psalm-testsuite phpstan-testsuite behat-testsuite phpunit-testsuite
coverage: phpunit-coverage

dev-start: up-dev dump-dev db-create db-migrate
prod-start: up dump-prod db-create db-migrate

stop-all: stop

# Start supervisord to monitor consumer
prod-start dev-start: supervisord