FROM php:8.4-alpine

#install sys dependancies
RUN apk add --no-cache libpng-dev libzip-dev zip unzip git postgresql-dev

#install php extension for postgres
RUN  docker-php-ext-install pdo pdo_pgsql gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
