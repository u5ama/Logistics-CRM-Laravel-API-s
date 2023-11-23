#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

php /var/www/html/artisan migrate --force

exec apache2-foreground
