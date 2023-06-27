#!/usr/bin/env bash

container=$(docker-compose -f docker/docker-compose.yml ps -q php)
docker exec -it ${container} bash
