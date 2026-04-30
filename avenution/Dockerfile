FROM node:18-alpine as assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.2-cli
WORKDIR /var/www/html

# Install system dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Create required Laravel directories before Composer scripts run
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy built assets from node
COPY --from=assets /app/public/build ./public/build

# Ensure storage and cache are writable
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Start Laravel using PHP's built-in server to avoid Apache MPM issues
CMD ["sh", "-c", "php artisan migrate --force 2>/dev/null || true; php artisan cache:clear 2>/dev/null || true; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
