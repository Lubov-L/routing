build:
	docker compose build
up:
	docker compose up -d
down:
	docker compose down
php-bash:
	docker compose exec php-routing bash
php-logs:
	docker compose logs php-routing
nginx-bash:
	docker compose exec nginx-routing bash
nginx-logs:
	docker compose logs nginx-routing
