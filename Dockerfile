# Stage 1: composer
FROM composer:2 AS vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Stage 2: frontend
FROM node:18 AS frontend
WORKDIR /app
COPY . .
RUN npm ci && npm run build

# Stage 3: final production image
FROM php:8.2-apache
RUN apt-get update && apt-get install -y git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libxml2-dev libicu-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY --from=vendor /app ./
COPY --from=frontend /app/public ./public
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh
RUN mkdir -p storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["bash","/usr/local/bin/startup.sh"]
