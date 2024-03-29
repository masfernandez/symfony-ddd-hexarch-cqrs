ARG PHP_VERSION=8.1.2

# --------------------------------------------
# base stage
# --------------------------------------------
FROM php:${PHP_VERSION}-fpm-alpine AS base

LABEL maintainer="Miguel Ángel Sánchez Fernández <mangel.sanfer@gmail.com>"

RUN apk --update upgrade \
    && apk add --no-cache \
        bash \
        git \
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

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# --------------------------------------------
# development stage
# --------------------------------------------
FROM base AS dev

RUN install-php-extensions \
        xdebug

COPY ./usr/local/etc/php/conf.d/xdebug.ini  /usr/local/etc/php/conf.d/xdebug.ini
COPY ./usr/local/bin/disable_xdebug.sh      /usr/local/bin/disable_xdebug
COPY ./usr/local/bin/enable_xdebug.sh       /usr/local/bin/enable_xdebug
RUN chmod u+x /usr/local/bin/disable_xdebug /usr/local/bin/enable_xdebug

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

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