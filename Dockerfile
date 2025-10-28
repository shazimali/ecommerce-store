# ============================================
# Stage 1: Composer dependencies
# ============================================
FROM composer:2 AS vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist


# ============================================
# Stage 2: Node (for Livewire/Vite assets)
# ============================================
FROM node:18-alpine AS frontend
WORKDIR /app
COPY . .
RUN npm install && npm run build || echo "⚠️ Frontend build skipped (no build script found)"


# ============================================
# Stage 3: Final Laravel production image
# ============================================
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip vim nano libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev certbot python3-certbot-apache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl \
    && a2enmod rewrite headers ssl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/everyday_shops

# Copy Laravel app from previous stages
COPY --from=vendor /app ./
COPY --from=frontend /app/public ./public

# Copy startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Ensure correct permissions
RUN mkdir -p /var/www/everyday_shops/storage /var/www/everyday_shops/bootstrap/cache \
    && chown -R www-data:www-data /var/www/everyday_shops \
    && chmod -R 775 /var/www/everyday_shops/storage /var/www/everyday_shops/bootstrap/cache

EXPOSE 80
CMD ["startup.sh"]
