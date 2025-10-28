# ============================================
# Stage 1: Install PHP dependencies with Composer
# ============================================
FROM composer:2 AS vendor
WORKDIR /app

# Copy only composer files first (cache layer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy full application for autoload & vendor files
COPY . .

# ============================================
# Stage 2: Build frontend (Livewire / npm)
# ============================================
FROM node:18 AS frontend
WORKDIR /app
COPY . .
RUN npm ci && npm run build

# ============================================
# Stage 3: Final production image
# ============================================
FROM php:8.2-apache

# Install system packages & PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip vim nano nodejs npm libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev openssl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl opcache \
    && a2enmod rewrite headers ssl \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy Laravel PHP + vendor
COPY --from=vendor /app ./

# Copy frontend build (public folder)
COPY --from=frontend /app/public ./public

# Copy Apache virtual host config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Ensure correct permissions
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80 443

CMD ["startup.sh"]
