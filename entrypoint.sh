#!/bin/bash

composer install --no-progress --no-interaction

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan migrate
php artisan key:generate

php artisan serve
exec docker-php-entrypoint "$@"
