FROM php:8.4-fpm-alpine

RUN apk update && apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]