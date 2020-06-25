#!/bin/bash

php-fpm -F -R
cd /var/www
php artisan migrate