#!/bin/bash
set -e

echo "⏳ Waiting for database connection..."
until php -r "try {
    new PDO(getenv('DB_CONNECTION').':host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'),
    getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo '✅ Database ready'; } catch (Exception \$e) { echo '.'; sleep(3); }"; do :; done

echo "🚀 Running Laravel optimizations..."
if [ -f artisan ]; then
    php artisan migrate --force || true
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan optimize
else
    echo "❌ artisan not found in current directory"
fi

echo "✅ Starting Apache server..."
exec apache2-foreground
