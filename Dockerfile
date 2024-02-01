FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    libxml2-dev \
    g++ \
    unzip

RUN docker-php-ext-install \
    intl \
    simplexml \
    opcache \
    pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY --chown=www-data:www-data . /app

RUN composer install --optimize-autoloader

EXPOSE 9000
