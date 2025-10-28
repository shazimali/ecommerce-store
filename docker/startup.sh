#!/bin/bash
set -e

echo "🚀 Starting Everyday Shop container setup..."

# Wait for MySQL to become available (if used via docker-compose)
if [ -n "$DB_HOST" ]; then
  echo "⏳ Waiting for database connection ($DB_HOST:$DB_PORT)..."
  until nc -z "$DB_HOST" "$DB_PORT"; do
    sleep 2
    echo "."
  done
  echo "✅ Database connection established."
fi

# Set correct permissions for Laravel
echo "🔧 Setting permissions..."
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure environment file exists
if [ ! -f /var/www/html/.env ]; then
  echo "⚠️ .env file not found! Copying from .env.example..."
  cp /var/www/html/.env.example /var/www/html/.env
fi

# Optimize Laravel for production
echo "⚙️ Running Laravel optimizations..."
cd /var/www/html

# Run Artisan commands safely
php artisan key:generate --force || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "✅ Laravel is optimized and ready."

# Enable Apache rewrite module (in case not active)
a2enmod rewrite headers > /dev/null 2>&1

# Restart Apache gracefully
echo "🌐 Starting Apache with virtual host configuration..."
apachectl -D FOREGROUND
