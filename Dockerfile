# ============================================
# Stage 1: Composer dependencies (CACHEABLE)
# ============================================
FROM composer:2 AS vendor

WORKDIR /app

ENV COMPOSER_MEMORY_LIMIT=-1

# Copy ONLY composer files first
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copy rest of PHP source
COPY . .

# ============================================
# Stage 2: Frontend build (CACHEABLE)
# ============================================
FROM node:18-alpine AS frontend

WORKDIR /app

# Copy ONLY frontend dependency files first
COPY package.json package-lock.json ./

RUN npm ci --no-audit --no-fund

# Copy rest of frontend files
COPY . .

RUN npm run build

# ============================================
# Stage 3: Final Laravel production image
# ============================================
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath \
    gd \
    zip \
    intl \
    && a2enmod rewrite headers ssl \
    && rm -rf /var/lib/apt/lists/*

# Set main domain to avoid Apache warnings
RUN echo "ServerName everydayplastic.co" >> /etc/apache2/apache2.conf

# Copy updated Apache virtual host config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Disable canonical name enforcement for multi-domain support
RUN sed -i '/<\/VirtualHost>/i UseCanonicalName Off' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/everyday_shop

# Copy backend + vendor
COPY --from=vendor /app ./

# Copy built frontend assets only
COPY --from=frontend /app/public ./public

COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data . \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["startup.sh"]
