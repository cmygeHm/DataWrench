#!/usr/bin/env bash

DOCKER_IMAGE_ID=php:7.4.5-cli-alpine

docker pull ${DOCKER_IMAGE_ID}

APP_ENV=test composer install --ignore-platform-reqs --no-scripts

docker run --rm  \
           --env=APP_ENV=test \
           -v "$(pwd):/app" \
           -u "$(id -u):$(id -g)" \
           ${DOCKER_IMAGE_ID} \
           /app/vendor/bin/phpunit --configuration /app/phpunit.xml --log-junit /app/junit.xml

