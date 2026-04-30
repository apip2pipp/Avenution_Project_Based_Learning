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
# Copy composer files first to leverage Docker cache when dependencies don't change
COPY composer.json composer.lock* ./

# Install PHP dependencies earlier (cacheable layer)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-ansi --no-interaction --prefer-dist && rm -rf /root/.composer/cache

# Create required Laravel directories before copying rest of application
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Copy application files
COPY . .

# Copy built assets from node
COPY --from=assets /app/public/build ./public/build

# Ensure storage and cache are writable
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Start Laravel using PHP's built-in server to avoid Apache MPM issues
CMD ["sh", "-c", "php artisan migrate --force || true; php artisan db:seed || true; php artisan cache:clear || true; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
