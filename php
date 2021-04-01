#!/usr/bin/env bash
# ____________________________________________________________________________________________
# How to use this script?
#
# Execute at root:
# ./php <command to execute at container>
#
# Example:
# ./php php -v
# ____________________________________________________________________________________________

docker exec -it docker-symfony-php $@