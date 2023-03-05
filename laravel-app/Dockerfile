FROM php:7.4-fpm

WORKDIR /var/www/html

# Install required extensions and libraries
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        curl \
        git \
    && docker-php-ext-install pdo_mysql zip gd exif pcntl bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application files to the container
COPY . .

# Install application dependencies
RUN composer install

# Run migrations
RUN php artisan migrate

# Run migrations
RUN php artisan world:init

# Install passport
RUN php artisan passport:install

# Run seeders for basic data
RUN php artisan db:seed

# Generate application key
RUN php artisan key:generate

# Set the command to start the application
CMD ["php-fpm"]
