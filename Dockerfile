# Use the official PHP image as a parent image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip git sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Set working directory
WORKDIR /var/www

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Copy existing application directory contents
COPY . /var/www

# Pastikan file database.sqlite ada di /app/database/database.sqlite (Railway working dir)
RUN mkdir -p /app/database && cp /var/www/database/database.sqlite /app/database/database.sqlite || true

# Install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy existing application directory permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
