#!/usr/bin/env bash

APP="./vendor/bin/phpunit"

COMMAND="${APP} ${@}"

docker exec -i $(docker ps --filter="name=press-fpm" -q) cmd "${COMMAND}"
