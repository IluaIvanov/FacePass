#!/usr/bin/make
# Makefile readme (ru): <http://linux.yaroslavl.ru/docs/prog/gnu_make_3-79_russian_manual.html>
# Makefile readme (en): <https://www.gnu.org/software/make/manual/html_node/index.html#SEC_Contents>

SHELL = /bin/sh

# Important: Local images naming should be in docker-compose naming style

APP_CONTAINER_NAME := app
NODE_CONTAINER_NAME := node
NGINX_CONTAINER_NAME := nginx
PGSQL_CONTAINER_NAME := pgsql

.PHONY : help build \
         up down restart shell install
.DEFAULT_GOAL := help

help: ## Show this help
#	@findstr /v "findstr" help.txt  #command for windows
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
# --- [ Application ] -------------------------------------------------------------------------------------------------

build: ## Application - build Docker image locally
	docker-compose build app

# --- [ Development tasks ] -------------------------------------------------------------------------------------------

---------------: ## ---------------

up: ## Start all containers (in background) for development
	docker-compose up -d

down: ## Stop all started for development containers
	docker-compose down

restart: up ## Restart all started for development containers
	docker-compose restart

shell: up ## Start shell into application container
	docker-compose exec "$(APP_CONTAINER_NAME)" /bin/sh

install: up ## Install application dependencies into application container
	docker-compose exec "$(APP_CONTAINER_NAME)" composer install

app-c: ## allows you to enter an arbitrary command for container app(make app-c command="php artisan optimize")
	docker-compose exec "$(APP_CONTAINER_NAME)" $(command)