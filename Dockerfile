# ========================================
# 1️⃣ Build Frontend (Vite + NPM)
# ========================================
FROM node:20 AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


# ========================================
# 2️⃣ Build Laravel App (PHP + Apache)
# ========================================
FROM php:8.2-apache-bullseye

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# ---- Fix repo sources + install tools ----
RUN sed -i 's|deb.debian.org|deb.debian.org|g' /etc/apt/sources.list \
    && apt-get clean \
    && apt-get update --fix-missing \
    && apt-get install -y apt-transport-https ca-certificates curl gnupg2 lsb-release \
    && apt-get update

# ---- Install System Dependencies ----
RUN apt-get install -y \
    git unzip zip vim nano wget \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev locales \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring bcmath zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# ---- Copy Composer ----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---- App Workdir ----
WORKDIR /var/www/html

# ---- Copy Laravel code ----
COPY . .

# ---- Copy built frontend assets ----
COPY --from=frontend /app/public/build ./public/build

# ---- Install PHP Dependencies ----
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ---- Laravel optimize & migrations ----
RUN php artisan key:generate --force || true \
    && php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan migrate --force || true \
    && php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# ---- Fix permissions ----
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
