#!/usr/bin/env bash
set -e
APP_DIR="/var/www/everyday_shops"
COMPOSE_FILE="$APP_DIR/docker-compose.prod.yml"
IMAGE="ghcr.io/<GITHUB_OWNER>/everyday_shops_app:latest"

cd "$APP_DIR"

# If using an image registry, pull latest (fails gracefully if not present)
docker pull $IMAGE || true

# Recreate stack
docker compose -f "$COMPOSE_FILE" up -d --remove-orphans --build

# Wait a little for containers to start
sleep 5

# Run migrations & clear cache
docker exec -i everyday_shops_app bash -lc "composer install --no-dev --optimize-autoloader || true"
docker exec -i everyday_shops_app bash -lc "php artisan key:generate --force || true"
docker exec -i everyday_shops_app bash -lc "php artisan migrate --force || true"
docker exec -i everyday_shops_app bash -lc "php artisan storage:link || true"
docker exec -i everyday_shops_app bash -lc "php artisan config:cache || true"

docker image prune -f || true

echo "Deploy finished."
