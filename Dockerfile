# Use official PHP with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip vim nano wget \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev locales \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring bcmath zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Copy application source
COPY . /var/www/html

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Clear caches and optimize Laravel
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan optimize

# Run database migrations automatically (optional — can be disabled if needed)
RUN php artisan migrate --force || true

# Expose Apache port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
