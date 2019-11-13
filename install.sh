#!/usr/bin/env bash

docker build -f press-fpm ./docker/php-fpm/

echo '{}' > composer.lock
chmod 777 ./composer.lock

mkdir -m 777 vendor

sh bin/composer.sh install -n --optimize-autoloader