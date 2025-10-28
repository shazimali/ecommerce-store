#!/bin/bash
set -e

echo "⏳ Waiting for database connection..."
until php -r "try {
    new PDO(getenv('DB_CONNECTION').':host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'),
    getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo '✅ Database ready\n'; } catch (Exception \$e) { echo '.'; sleep(3); }"; do :; done

echo "🚀 Running Laravel optimizations..."
php artisan migrate --force || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Enable HTTPS for multiple domains if ENABLE_HTTPS=true
if [ "$ENABLE_HTTPS" = "true" ]; then
    echo "🔒 Configuring HTTPS with Certbot..."
    for DOMAIN in $(echo $DOMAINS | tr ',' ' '); do
        certbot --apache --non-interactive --agree-tos --redirect \
            --email "$EMAIL" -d "$DOMAIN" || true
    done
fi

echo "✅ Starting Apache server..."
apache2-foreground
