## Executables
DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml
DOCKER_COMPOSE_TEST=$(DOCKER_COMPOSE)
DOCKER_COMPOSE_TEST_PCOV=$(DOCKER_COMPOSE) -f docker/docker-compose-pcov.yml
DOCKER_COMPOSE_TEST_XDEBUG=$(DOCKER_COMPOSE) -f docker/docker-compose-xdebug.yml
DOCKER_COMPOSE_XDEBUG=$(DOCKER_COMPOSE) -f docker/docker-compose-xdebug.yml
DOCKER_COMPOSE_GENERATE_COVERAGE=$(DOCKER_COMPOSE) run --rm --no-deps php bin/phpcov merge build/coverage --html build/coverage/merged/html

## Docker containers
PHP_CONTAINER_ID=$$($(DOCKER_COMPOSE) ps -q php)

## Arguments
ARGUMENTS=$(filter-out $@,$(MAKECMDGOALS))

.DEFAULT_GOAL=help
.PHONY=help build up down logs composer console phpunit behat test

###
### Help
help: ## List targets
	@printf "\nUsage: make <command>\n"
	@grep -E '(^[a-zA-Z0-9\._-]+:$$)|(^[a-zA-Z0-9\._-]+:.*?##.*$$)|(^### .*$$)' $(MAKEFILE_LIST) \
	| sed -e 's/^###/\n\0/' \
	| sed -e 's/\(^[A-Za-z0-9\._-]\+:\)\( [ A-Za-z0-9\._-]\+ \)\(## .*$$\)/\1 \3/' \
	| sed -e 's/^[A-Za-z0-9\._-]/\t\0/' \
	| sed -e 's/://'

###
### Docker
build: ## Build container
	@$(DOCKER_COMPOSE) build --pull

up: ## Up containers
	@$(DOCKER_COMPOSE) up --detach

down: ## Down containers and remove orphans
	@$(DOCKER_COMPOSE) down --remove-orphans

start: build up ## Build and up containers

start.xdebug: build ## Build and up with xdebug
	@$(DOCKER_COMPOSE_XDEBUG) up --detach --build

stop: ## Stop containers
	@$(DOCKER_COMPOSE) stop

logs: ## Show containers logs
	@$(DOCKER_COMPOSE) logs --tail=10 --follow

bash:
	@docker exec -it $(PHP_CONTAINER_ID) bash

###
### Composer
composer:
	@$(DOCKER_COMPOSE) run --rm --remove-orphans --no-deps --env COMPOSER_MEMORY_LIMIT=-1 php composer $(ARGUMENTS)

###
### Symfony
console:
	@docker exec $(PHP_CONTAINER_ID) php bin/console $(ARGUMENTS)

consume:
	@docker exec $(PHP_CONTAINER_ID) php bin/console messenger:consume async -vv

###
### Database
database.create:
	@docker exec $(PHP_CONTAINER_ID) php bin/console doctrine:database:create --if-not-exists

database.migrate:
	@docker exec $(PHP_CONTAINER_ID) php bin/doctrine-migrations migrations:migrate --allow-no-migration --no-interaction --configuration=/var/www/config/migrations/doctrine-config.php --db-configuration=/var/www/config/migrations/doctrine-db.php

###
### Test
unit:
	@$(DOCKER_COMPOSE_TEST) run --rm --no-deps php bin/phpunit --no-coverage

unit.coverage:
	@$(DOCKER_COMPOSE_TEST_PCOV) run --no-deps --build --rm php bin/phpunit

unit.xdebug:
	@$(DOCKER_COMPOSE_TEST_XDEBUG) run --no-deps --build --rm php bin/phpunit

functional:
	@$(DOCKER_COMPOSE_TEST) run --rm php tests/run.sh functional

functional.coverage:
	@$(DOCKER_COMPOSE_TEST) run --rm php tests/run.sh functional-coverage

test: unit functional

test.coverage: unit.coverage functional.coverage
	@$(DOCKER_COMPOSE_GENERATE_COVERAGE)

###
### Code Quality
phpstan:
	@$(DOCKER_COMPOSE_TEST) run --rm --no-deps php bin/phpstan

rector:
	@$(DOCKER_COMPOSE_TEST) run --rm --no-deps php bin/rector process src

ecs:
	@$(DOCKER_COMPOSE_TEST) run --rm --no-deps php bin/ecs check src --fix

code.quality: rector ecs phpstan

###
## ARGUMENT no rule to make target message fix
%:
	@: