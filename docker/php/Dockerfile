ARG PHP_VERSION=8.1.2

# --------------------------------------------
# base stage
# --------------------------------------------
FROM php:${PHP_VERSION}-fpm-alpine AS base

LABEL maintainer="Miguel Ángel Sánchez Fernández <mangel.sanfer@gmail.com>"

RUN apk --update upgrade \
    && apk add --no-cache \
        bash \
        make \
        supervisor

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
        amqp \
        bcmath \
        gmp \
        intl \
        pdo_mysql \
        redis \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --------------------------------------------
# development stage
# --------------------------------------------
FROM base AS dev

RUN install-php-extensions \
        xdebug

COPY ./usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
COPY ./usr/local/etc/php/conf.d/symfony.dev.ini /usr/local/etc/php/conf.d/symfony.ini

# --------------------------------------------
# production stage
# --------------------------------------------
FROM base AS prod

RUN install-php-extensions \
        opcache \
        apcu

RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY ./usr/local/etc/php/conf.d/symfony.prod.ini /usr/local/etc/php/conf.d/symfony.ini