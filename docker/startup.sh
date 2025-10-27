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
    echo "⚠️ artisan not found — skipping Laravel optimizations."
fi

# ==================================================
# SSL Configuration
# ==================================================
SSL_CERT_PATH="/etc/ssl/certs/apache-selfsigned.crt"
SSL_KEY_PATH="/etc/ssl/private/apache-selfsigned.key"

if [ "$ENABLE_HTTPS" = "true" ]; then
    echo "🔒 Enabling HTTPS mode..."

    # Generate self-signed cert if missing
    if [ ! -f "$SSL_CERT_PATH" ] || [ ! -f "$SSL_KEY_PATH" ]; then
        echo "🧾 Generating self-signed SSL certificate..."
        mkdir -p /etc/ssl/certs /etc/ssl/private
        openssl req -x509 -nodes -days 365 \
            -subj "/C=PK/ST=Sindh/L=Karachi/O=EverydayShop/CN=everydayplastic.co" \
            -newkey rsa:2048 \
            -keyout "$SSL_KEY_PATH" \
            -out "$SSL_CERT_PATH"
    else
        echo "✅ SSL certificate already exists."
    fi

    a2enmod ssl
    service apache2 reload
else
    echo "🌐 Running in HTTP mode."
fi

echo "✅ Starting Apache server..."
apache2-foreground
