FROM composer:2 as vendor

WORKDIR /var/www
COPY composer.json composer.lock* ./
RUN composer update --no-dev --optimize-autoloader --no-interaction --no-scripts

FROM php:8.3-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    oniguruma-dev \
    sqlite-dev \
    libxml2-dev \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        pcntl \
        xml \
        gd \
    && rm -rf /var/cache/apk/*

COPY --from=vendor /var/www/vendor ./vendor

COPY . .

RUN echo "APP_KEY=" > .env && php artisan key:generate --force
RUN php artisan jwt:secret --force
RUN php artisan migrate --force
RUN touch /var/www/database/database.sqlite

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]