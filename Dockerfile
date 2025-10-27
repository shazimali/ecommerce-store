# ============================================
# Stage 1: Composer Dependencies
# ============================================
FROM composer:2 AS vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ============================================
# Stage 2: Frontend Build (Laravel Livewire)
# ============================================
FROM node:18 AS frontend
WORKDIR /app
COPY . .
RUN npm install && npm run build

# ============================================
# Stage 3: Final Production Image
# ============================================
FROM php:8.2-apache

# Install required system packages
RUN apt-get update && apt-get install -y \
    git curl zip unzip vim nano libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev openssl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules for Laravel + SSL
RUN a2enmod rewrite ssl headers && service apache2 restart

# Set working directory
WORKDIR /var/www/html

# Copy files from build stages
COPY --from=vendor /app ./
COPY --from=frontend /app/public ./public

# Copy Apache configuration (for your custom virtual hosts)
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Set proper permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80 443


CMD ["startup.sh"]
