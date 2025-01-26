FROM php:8.3-fpm

WORKDIR /app

RUN docker-php-ext-install pdo pdo_mysql
