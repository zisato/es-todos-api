#!/usr/bin/env bash

docker-compose -f ${PWD}/docker/docker-compose.yml pull
docker-compose -f ${PWD}/docker/docker-compose.yml run php-cli "/var/www/bin/phpstan" "analyse" "-l" "7"
exitCode=$?
docker-compose -f ${PWD}/docker/docker-compose.yml down
exit $exitCode