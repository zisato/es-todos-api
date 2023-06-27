#!/usr/bin/env bash

docker-compose -f ${PWD}/docker/docker-compose.yml run mysql "CREATE DATABASE employeesdb;" 
exitCode=$?
docker-compose -f ${PWD}/docker/docker-compose.yml down
exit $exitCode