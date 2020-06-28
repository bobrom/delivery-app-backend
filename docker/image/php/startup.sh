#!/bin/bash

set -e

echo "Execute custom start-up script"
#php artisan migrate
#just for test
pwd
ls -la

echo "Execute main"
exec "$@"
