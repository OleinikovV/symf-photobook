FROM php:8.1-fpm-alpine

RUN apk add \
    bash \
    git \
    libpng-dev \
    libxml2-dev \
    openssh \
    postgresql-dev \
    libzip-dev \
    autoconf \
    build-base

RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql

COPY ./ /usr/local/etc/php/

COPY ./conf.d/php.ini /usr/local/etc/php/php.ini


RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    sed -E -i -e 's/;?\s*display_errors\s*=.+$/display_errors = On/g' /usr/local/etc/php/php.ini && \
    echo 'xdebug.remote_enable = 1' >> /usr/local/etc/php/php.ini && \
    echo 'xdebug.start_with_request = yes' >> /usr/local/etc/php/php.ini && \
    echo 'xdebug.mode = develop,debug' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.client_host = host.docker.internal' >> /usr/local/etc/php/php.ini && \
    echo 'xdebug.client_port = 9003' >> /usr/local/etc/php/php.ini


COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /symfony
