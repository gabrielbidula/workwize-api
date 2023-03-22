# Executables (local)
DOCKER_COMP = docker-compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec app

# Executables
PHP      = $(PHP_CONT) php
ARTISAN  = $(PHP_CONT) php artisan
COMPOSER = $(PHP_CONT) composer

.PHONY: setup
setup: build up composer-install env db-fresh ## Setup

.PHONY: db-fresh
db-fresh: fresh seed ## Fresh and seed the database

.PHONY: ide-helper
ide-helper: ide-helper-meta ide-helper-generate ide-helper-eloquent ide-helper-model enum-annotate ## Generates helper files that enable your IDE to provide accurate autocompletion

.PHONY: analysis
analysis: pint phpstan ## Run analysis tools

.PHONY: env
env: cp-env key-generate

.PHONY: build
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

.PHONY: up
up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach --wait

.PHONY: fresh
fresh: ## Fresh the database
	@$(ARTISAN) migrate:fresh

.PHONY: seed
seed: ## Seed the database
	@$(ARTISAN) db:seed

.PHONY: ide-helper-meta
ide-helper-meta: ## PhpStorm Meta file
	@$(ARTISAN)	ide-helper:meta

.PHONY: ide-helper-generate
ide-helper-generate: ## PHPDoc generation for Laravel Facades
	@$(ARTISAN)	ide-helper:generate

.PHONY: ide-helper-eloquent
ide-helper-eloquent: ## PHPDocs for models
	@$(ARTISAN)	ide-helper:eloquent

.PHONY: ide-helper-model
ide-helper-model: ## PHPDocs for models
	@$(ARTISAN)	ide-helper:model --reset --write

.PHONY: enum-annotate
enum-annotate: ## PHPDocs for enums
	@$(ARTISAN)	enum:annotate

.PHONY: down
down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

.PHONY: logs
logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

.PHONY: sh
sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

.PHONY: composer-install
composer-install: ## Run composer install
	@$(COMPOSER) install

.PHONY: cp-env
cp-env: ## Copy .env.example to .env
	@$(PHP_CONT) cp .env.example .env

.PHONY: key-generate
key-generate: ## Generate app key
	@$(ARTISAN) key:generate

.PHONY: test
test: ## Tests the application
	@$(PHP_CONT) ./vendor/bin/pest

.PHONY: pint
pint: ## Laravel Pint - PHP code style fixer
	@$(PHP_CONT) ./vendor/bin/pint

.PHONY: phpstan
phpstan: ## PHPStan code analysis
	@$(PHP_CONT) ./vendor/bin/phpstan analyse --memory-limit=2G;
