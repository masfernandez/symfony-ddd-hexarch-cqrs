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
musiclabel-app-dir 	:= $(current-dir)apps/MusicLabel
musiclabel-backend 	:= $(musiclabel-app-dir)/backend

debug-paths:
	echo $(current-dir)
	echo $(musiclabel-app-dir)
	echo $(musiclabel-backend)

## —— envs —————————————————————————————————————————————————————————————————
env-file:
	@if [ ! -f .env ]; then cp .env.dist .env; fi
#@todo improve envs generation and delete app:dump-env command
dump-dev:
	ENV=dev ./console secrets:decrypt-to-local --force --env=dev
	ENV=dev ./console app:dump-env dev --env=dev

dump-test:
	ENV=test ./console secrets:decrypt-to-local --force --env=test
	ENV=test ./console app:dump-env test --env=test

dump-preprod:
	ENV=preprod ./console secrets:decrypt-to-local --force --env=preprod
	ENV=preprod ./console app:dump-env preprod --env=preprod

dump-prod:
	ENV=prod ./console secrets:decrypt-to-local --force --env=prod
	ENV=prod ./console app:dump-env prod --env=prod

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
	truncate -s 0 var/log/symfony/MusicLabel/*.log
	truncate -s 0 var/log/nginx/*.log

## —— Docker  ————————————————————————————————————————————————————————
up-test:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-dev.yml \
		up -d --remove-orphans

up-dev:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		-f docker-compose.local-dev.yml \
		up -d --remove-orphans

up-preprod:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		up -d --remove-orphans

up-prod:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		up -d --remove-orphans

stop-test:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-dev.yml \
		stop

stop-dev:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		-f docker-compose.local-dev.yml \
		stop

stop-preprod:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		stop

stop-prod:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		stop

up: up-prod
stop: stop-prod

down:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		down --remove-orphans

logs:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		logs -f

rebuild:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		build php nginx \
		--no-cache

update:
	$(DOCKER_COMPOSE-EXEC) \
		-f docker-compose.local.yml \
		-f docker-compose.local-prod.yml \
		pull \
		redis \
		mysql80 \
		mariadb106 \
		rabbitmq \
		elasticsearch \
		kibana \
		logstash \
		filebeat

## —— Consumer  ————————————————————————————————————————————————————————

supervisord:
	docker exec -it docker-symfony-php supervisord --configuration /etc/supervisor.d/supervisord.ini

## —— Composer ————————————————————————————————————————————————————————————

composer-install:
	@./composer install

composer-update:
	@./composer update

## —— PHP tests ————————————————————————————————————————————————————————————

phpcs: up-test phpcs-testsuite
phpcs-testsuite:
	ENV=test ./php vendor/bin/phpcs -p --colors --extensions=php --standard=PSR12  src tests

phpcs-build: up-test phpcs-build-testsuite
phpcs-build-testsuite:
	ENV=test ./php vendor/bin/phpcbf -p --colors --extensions=php --standard=PSR12 src tests

rector: up-test rector-testsuite
rector-testsuite:
	ENV=test ./php vendor/bin/rector process --dry-run --clear-cache

rector-build: up-test rector-build-testsuite
rector-build-testsuite:
	ENV=test ./php vendor/bin/rector process

phpstan: up-test phpstan-testsuite
phpstan-testsuite:
	ENV=test ./php vendor/bin/phpstan analyse -c phpstan.neon

psalm: up-test psalm-testsuite
psalm-testsuite:
	ENV=test ./php vendor/bin/psalm --long-progress --no-cache --no-file-cache

psalm-build: up-test psalm-build-testsuite
psalm-build-testsuite:
	ENV=test ./php vendor/bin/psalm --alter --issues=InvalidReturnType,MissingParamType --dry-run

phpunit: up-test dump-test db-drop db-create-sqlite phpunit-testsuite
phpunit-testsuite:
	rm -rf build/test
	ENV=test ./php vendor/bin/phpunit \
		--exclude-group='disabled' \
		--log-junit build/test/phpunit/junit.xml tests

phpunit-coverage: up-test dump-test db-drop db-create-sqlite phpunit-coverage-testsuite
phpunit-coverage-testsuite:
	rm -rf build/test
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
	ENV=test ./php vendor/bin/behat -f progress

## —— elastic  ————————————————————————————————————————————————————————————
filebeat-dashboards:
	$(DOCKER-EXEC) exec -it docker-symfony-filebeat filebeat setup --dashboards

## —— examples  ————————————————————————————————————————————————————————————
create-demo-user:
	./console app:create-user 'test@email.com' '1234567890'

## —— RUN  ————————————————————————————————————————————————————————————
tests: \
	env-file \
	up-test \
	dump-test \
	db-drop \
	db-create-sqlite \
	rector-testsuite \
	phpcs-testsuite \
	psalm-testsuite \
	phpstan-testsuite \
	behat-testsuite \
	phpunit-testsuite \
	phpunit-coverage-testsuite
coverage: \
	phpunit-coverage
dev-start: \
	env-file \
	up-dev \
	dump-dev \
	db-create \
	db-migrate
preprod-start: \
	up-preprod \
	dump-prod \
	db-create \
	db-migrate
prod-start: \
	up-prod \
	dump-prod \
	db-create \
	db-migrate

stop-all: stop-prod

# Start supervisord to monitor consumer
prod-start dev-start: supervisord