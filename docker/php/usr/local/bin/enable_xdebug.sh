#!/bin/bash

sed -i "s/^xdebug.start_with_request=no/xdebug.start_with_request=yes/g" /usr/local/etc/php/conf.d/xdebug.ini
kill -USR2 1