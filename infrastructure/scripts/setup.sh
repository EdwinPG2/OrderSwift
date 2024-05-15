#!/usr/bin/env bash
set -e

echo "*****************************"
echo "Setup the docker container"
echo "Environment: ${APP_ENV}"
echo "*****************************"

# Opcache
echo "Opcache configuration"
cp /var/www/infrastructure/opcache/200_opcache.ini /usr/local/etc/php/conf.d/

# General PHP settings
echo "General php ini settings"
cp /var/www/infrastructure/php-ini/300_ibiz.ini /usr/local/etc/php/conf.d/

# Root CA Certificates
echo "Root CA Certificates installed in OS"
cp /var/www/infrastructure/ssl/ca-certificates.crt /etc/ssl/certs/ca-certificates.crt

# Ensure Timezone is Los_Angeles
echo "Timezone should be Los_Angeles"
ln -snf /usr/share/zoneinfo/America/Los_Angeles /etc/localtime && echo America/Los_Angeles > /etc/timezone

# Install the composer binary
echo "Installing composer..."
/var/www/infrastructure/scripts/composer.sh

# Run installations in the image only if we're not in local development
# If we're local, we'll be mounting our folder which would remove these installations...
if [ "${APP_ENV}" != "local" ]; then
    echo "Running composer install and npm install"
    if [ "${APP_ENV}" = "development" ]; then

        echo "Since development composer runs without the --no-dev parameter"
        composer install --no-interaction --prefer-dist --optimize-autoloader
    else
        echo "Composer production install"
        composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
    fi

    # Get the Road Runner binary
    echo "Installing the road runner binary"
    /var/www/vendor/bin/rr get-binary

    # npm install
    echo "npm install"
    npm ci
    npm run prod

else

    echo "composer install and npm install did not run since you are in local environment"

fi