#!/usr/bin/env bash
# ____________________________________________________________________________________________
# How to use this script?
#
# Execute at root:
# ./php <command to execute at container>
#
# Examples:
# ./php php -v
# ./php composer install
# ./php composer update
# ____________________________________________________________________________________________

if [ ! "$(docker ps -a | grep docker-symfony-php)" ]; then
  make dev-start
fi

docker exec -it docker-symfony-php $@