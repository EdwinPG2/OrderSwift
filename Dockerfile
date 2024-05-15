# https://laravel.com/docs/9.x/deployment#server-requirements
# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \ 
    curl \
    git \
    libcurl4-openssl-dev \
    libicu-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    supervisor \
    zip \
    libmagickwand-dev

RUN docker-php-ext-install \ 
    bcmath \
    ctype \
    curl \
    dom \
    fileinfo \
    gd \
    intl \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    sockets \
    xml \
    zip \
    soap 


# Redis
RUN pecl install redis imagick && \
    docker-php-ext-enable redis imagick

# Node 16. We upgrade NPM to make the install a little faster
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt install -y nodejs && \
    npm install -g npm@latest

# Providing defaults in case not sent by user
ARG APP_KEY
ARG APP_ENV
ENV APP_KEY=${APP_KEY}
ENV APP_ENV=${APP_ENV:-production}

WORKDIR /var/www
COPY --chown=www-data:www-data . /var/www

RUN chmod -R +x /var/www/infrastructure/scripts
RUN /var/www/infrastructure/scripts/setup.sh

CMD ["/var/www/infrastructure/scripts/start.sh"]
