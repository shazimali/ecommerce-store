FROM php:8.2-apache-bookworm

LABEL maintainer="Everyday Shops DevOps <devops@everydayshops>"

# Non-interactive installation
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# ---------------------------------------------------------
# System dependencies
# ---------------------------------------------------------
RUN apt-get update --fix-missing \
    && apt-get install -y --no-install-recommends \
    apt-utils ca-certificates curl wget git unzip zip vim nano locales gnupg2 \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring bcmath zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# ---------------------------------------------------------
# Install Composer
# ---------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------------------------------------------------------
# Work directory
# ---------------------------------------------------------
WORKDIR /var/www/html

# ---------------------------------------------------------
# Copy app files
# ---------------------------------------------------------
COPY . .

# ---------------------------------------------------------
# Install PHP dependencies
# ---------------------------------------------------------
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# ---------------------------------------------------------
# Laravel setup (safe mode)
# ---------------------------------------------------------
RUN php artisan key:generate --force || true \
    && php artisan migrate --force || true \
    && php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# ---------------------------------------------------------
# Fix permissions
# ---------------------------------------------------------
RUN chown -R www-data:www-d
