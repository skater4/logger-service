.PHONY: up down build serve migrate clearcache

up:
	docker-compose config -q && \
	docker-compose up -d --force-recreate --remove-orphans

down:
	docker-compose config -q && \
	docker-compose down

reboot:
	make down && make up

build:
	docker-compose config -q && \
	docker-compose build --pull

composer-install:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache composer install

composer-update:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache composer update

composer-dump:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache composer dump-autoload -o

ide-helper:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan ide-helper:generate

ide-helper-models:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan ide-helper:models

generate-key:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan key:generate

migrate:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan migrate

seed:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan db:seed

test:
	docker-compose config -q && \
	docker-compose exec loggerapi-apache php artisan test

npm-install:
	docker-compose config -q && \
	docker-compose run --rm loggerapi-node npm i && \
	docker-compose run --rm loggerapi-node npm install dotenv && \
	docker-compose run --rm loggerapi-node npm install jquery && \
	docker-compose run --rm loggerapi-node npm run build

npm-watch:
	docker-compose config -q && \
	docker-compose run --rm loggerapi-node npm run watch

webpack:
	docker-compose config -q && \
	docker-compose run --rm loggerapi-node npm run dev

clearcache:
	docker-compose exec loggerapi-apache php artisan cache:clear; \
	docker-compose exec loggerapi-apache php artisan clear-compiled; \
	docker-compose exec loggerapi-apache php artisan config:clear; \
	docker-compose exec loggerapi-apache php artisan route:clear; \
	docker-compose exec loggerapi-apache php artisan view:clear; \
	docker-compose exec loggerapi-apache php artisan optimize; \
	docker-compose exec loggerapi-redis redis-cli FLUSHALL; \
	true