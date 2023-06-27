#!/usr/bin/env bash

docker-compose -f docker/docker-compose.yml pull
docker-compose -f docker/docker-compose.yml up -d $*