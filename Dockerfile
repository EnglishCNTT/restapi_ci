FROM php:8.2-fpm

WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql