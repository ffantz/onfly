setup:

build:
	docker-compose build --no-cache --force-rm

up:
	docker-compose up -d

stop:
	docker-compose stop

composer-update:
	docker exec onfly_app bash -c "composer update"

setup:
	docker exec onfly_app bash -c "cp .env.example .env"
	docker exec onfly_app bash -c "php artisan key:generate"
