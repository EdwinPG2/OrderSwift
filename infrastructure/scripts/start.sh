#!/usr/bin/env bash
set -e

echo "*****************************"
echo "Start the docker container"
echo "Environment: ${APP_ENV}"
echo "Role: ${CONTAINER_ROLE}"
echo "*****************************"



    echo "Starting the app through octane->roadrunner"
    exec /usr/bin/supervisord -c /var/www/infrastructure/supervisor/octane.conf

