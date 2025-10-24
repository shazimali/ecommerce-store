# =========================
# 1️⃣ Frontend build (Vite)
# =========================
FROM node:20 AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


# =========================
# 2️⃣ PHP + Apache (Laravel)
# =========================
FROM php:8.2-apache-bullseye

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# --- Fix for some VPS DNS/mirror issues ---
RUN apt-get update --fix-missing \
    && apt-get install -y apt-transport-https ca-certificates gnupg lsb-release curl

# --- Install all system dependencies ---
RUN apt-get update && apt-get install -y \
    git unzip zip vim nano curl wget \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libxml2-dev locales libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring bcmath zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# --- Set working directory ---
WORKDIR /var/www/html

# --- Copy Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Copy app code ---
COPY . .

# --- Copy built frontend assets ---
COPY --from=frontend /app/public/build ./public/build

# --- Install PHP dependencies ---
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# --- Laravel cache & migrations ---
RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && (php artisan key:generate --force || true) \
    && php artisan migrate --force || true \
    && php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# --- Fix permissions ---
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
