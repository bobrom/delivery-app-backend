#!/bin/bash

php-fpm -F -R
cd /var/www
echo "Running migrations"
php artisan migrate
