FROM node:18-alpine as assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.2-apache
WORKDIR /var/www/html

# Install PHP extensions including gd and zip
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip mysqli pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite dan disable conflict modules
RUN a2dismod mpm_prefork mpm_worker mpm_event 2>/dev/null || true
RUN a2enmod rewrite mpm_prefork

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY --chown=www-data:www-data . .

# Create necessary directories before composer install
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Copy built assets from node
COPY --from=assets /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Copy Apache config
COPY apache_app.conf /etc/apache2/conf-available/app.conf
RUN a2enconf app

# Create storage directory
RUN mkdir -p storage/logs && chown -R www-data:www-data storage

EXPOSE 80

# Setup and start
RUN a2disconf app 2>/dev/null || true
RUN a2enconf app

# Run artisan commands and start apache
CMD ["sh", "-c", "php artisan migrate --force 2>/dev/null; php artisan cache:clear 2>/dev/null; apache2-foreground"]
