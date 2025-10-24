# ------------------------------------------
# Stage 1: Base PHP + Apache Image
# ------------------------------------------
FROM php:8.2-apache AS base

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update --fix-missing && apt-get install -y \
    git unzip zip vim nano wget curl pkg-config \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libxml2-dev libicu-dev libonig-dev locales \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring bcmath zip intl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Copy composer from the official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy the entire project (for later build context)
COPY . .

# ------------------------------------------
# Stage 2: Builder (Composer + NPM logic)
# ------------------------------------------
FROM base AS builder

WORKDIR /var/www/html

# Ensure Node.js + npm are available
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && npm install -g npm@latest

# -------- Smart Composer Build --------
RUN if [ ! -f composer.lock ] || [ composer.json -nt composer.lock ]; then \
    echo "Detected composer.json change → running composer update..."; \
    composer update --no-interaction --prefer-dist --optimize-autoloader; \
    else \
    echo "composer.lock is up-to-date → running composer install..."; \
    composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi

# -------- Smart NPM Build --------
RUN if [ -f package.json ]; then \
    if [ ! -f package-lock.json ] || [ package.json -nt package-lock.json ]; then \
    echo "Detected package.json change → reinstalling dependencies..."; \
    npm install; \
    else \
    echo "Using existing package-lock.json → running npm ci..."; \
    npm ci; \
    fi && \
    echo "Building frontend assets..."; \
    npm run build; \
    else \
    echo "No package.json found, skipping npm build."; \
    fi

# ------------------------------------------
# Stage 3: Final Production Image
# ------------------------------------------
FROM base AS production

WORKDIR /var/www/html

# Copy built app from builder
COPY --from=builder /var/www/html /var/www/html

# Laravel optimization and cache clearing
RUN php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Default command to start Apache
CMD ["apache2-foreground"]
