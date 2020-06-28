#!/bin/bash

set -e

echo "Execute custom start-up script"
php artisan migrate

echo "Execute main"
exec "$@"
