# ============================================
# Stage 1: Composer Dependencies
# ============================================
FROM composer:2 AS vendor
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies (assumes composer.lock exists)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy full application
COPY . .


# ============================================
# Stage 2: Frontend Build (Laravel Livewire)
# ============================================
FROM node:18 AS frontend
WORKDIR /app
COPY . .
RUN npm ci && npm run build || true

# ============================================
# Stage 3: Final Production Image
# ============================================
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip vim nano libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev openssl nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl \
    && a2enmod rewrite ssl headers \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy Laravel backend from vendor stage
COPY --from=vendor /app ./

# Copy built frontend assets
COPY --from=frontend /app/public ./public

# Copy Apache configuration
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Set Laravel permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80 443

CMD ["startup.sh"]
