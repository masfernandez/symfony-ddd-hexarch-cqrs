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

ENV="${ENV:-dev}"

if [ ! "$(docker ps | grep docker-symfony-php)" ]; then
  make $ENV-start
fi

docker exec -it docker-symfony-php php $@