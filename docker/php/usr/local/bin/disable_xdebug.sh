#!/bin/bash

sed -i "s/^xdebug.start_with_request=yes/xdebug.start_with_request=no/g" /usr/local/etc/php/conf.d/xdebug.ini
kill -USR2 1