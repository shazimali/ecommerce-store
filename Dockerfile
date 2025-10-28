# Stage 1: Composer Dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
COPY . .

# Stage 2: Frontend Build (Laravel Livewire)
FROM node:18 AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 3: Final Production Image
FROM php:8.2-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip vim nano libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev openssl nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl \
    && a2enmod rewrite headers ssl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy Laravel + Livewire app
COPY --from=vendor /app ./
COPY --from=frontend /app/public ./public

# Apache config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80 443
CMD ["startup.sh"]
