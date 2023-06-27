#!/usr/bin/env bash

docker-compose -f ${PWD}/docker/docker-compose.yml pull
docker-compose -f ${PWD}/docker/docker-compose.yml run php bin/doctrine-migrations migrations:migrate --allow-no-migration --no-interaction --configuration=/var/www/config/migrations/doctrine-config.php --db-configuration=/var/www/config/migrations/doctrine-db.php
