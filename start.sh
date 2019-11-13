#!/usr/bin/env bash

CURRENT=$(dirname $(realpath $0) )

docker run -d -v $(pwd):/var/www --rm --expose 8000 -p 8000:8000 --name press-fpm press-fpm

sleep 1

gnome-terminal --tab --title="test" --command="bash -c 'docker exec -ti $(docker ps --filter=name=press-fpm -q) php -S 0.0.0.0:8000 -t examples/;$SHELL'"
gnome-terminal --tab --title="test" --command="bash -c 'docker exec -ti $(docker ps --filter=name=press-fpm -q) php -S 0.0.0.0:8001 -t examples/server1/;$SHELL'"
gnome-terminal --tab --title="test" --command="bash -c 'docker exec -ti $(docker ps --filter=name=press-fpm -q) php -S 0.0.0.0:8002 -t examples/server2/;$SHELL'"
gnome-terminal --tab --title="test" --command="bash -c 'docker exec -ti $(docker ps --filter=name=press-fpm -q) php -S 0.0.0.0:8003 -t examples/server3/;$SHELL'"

sleep 4

docker exec -ti $(docker ps --filter=name=press-fpm -q) bash -c ""

sleep 10

docker stop $(docker ps -q)
