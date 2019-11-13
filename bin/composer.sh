#!/usr/bin/env bash


APP="php -d memory_limit=-1 /usr/local/bin/composer"

COMMAND="${APP} ${@}"

docker exec -i $(docker ps --filter="name=press-fpm" -q) cmd "${COMMAND}"
