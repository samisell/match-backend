
# Use a PHP-FPM image with Nginx for serving the application
FROM ghcr.io/coollabsio/coolify-images/php:8.2-alpine

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    nodejs \
    npm \
    git \
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    imagemagick-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd zip bcmath intl exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Copy composer.json and composer.lock first to leverage Docker cache
COPY composer.json composer.lock ./

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy the rest of the application code
COPY . .

# Generate application key if not already set (Coolify will handle .env)
RUN php artisan key:generate --force

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Configure Nginx
COPY ./.coolify/nginx.conf /etc/nginx/http.d/default.conf

# Configure Supervisor
COPY ./.coolify/supervisord.conf /etc/supervisord.conf

# Set permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port 80 for Nginx
EXPOSE 80

# Start Supervisor to manage Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]