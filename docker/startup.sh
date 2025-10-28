#!/bin/bash
set -e

# Wait for MySQL
echo "⏳ Waiting for database connection..."
until php -r "try { new PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo '✅ Database ready'; } catch (Exception \$e) { echo '.'; sleep(3); }"; do :; done

# Laravel optimizations
echo "🚀 Running Laravel optimizations..."
php artisan migrate --force || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Enable HTTPS if required
if [ "$ENABLE_HTTPS" = "true" ]; then
    echo "🔐 Setting up HTTPS with Certbot..."
    apt-get update && apt-get install -y certbot python3-certbot-apache
    IFS=',' read -r -a domains <<< "$DOMAINS"
    certbot --apache --non-interactive --agree-tos -m admin@$domains -d "${domains[@]}" || echo "⚠️ Certbot already configured."
fi

echo "✅ Starting Apache server..."
apache2-foreground
