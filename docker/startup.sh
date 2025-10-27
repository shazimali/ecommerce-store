#!/bin/bash
set -e

echo "⏳ Waiting for database connection..."
until php -r "try {
    new PDO(getenv('DB_CONNECTION').':host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'),
    getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo '✅ Database ready'; } catch (Exception \$e) { echo '.'; sleep(3); }"; do :; done

echo "🚀 Running Laravel optimizations..."
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan optimize || true

echo "✅ Starting Apache server..."
apache2-foreground
