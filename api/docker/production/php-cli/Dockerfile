FROM php:8.1-cli-alpine

LABEL org.opencontainers.image.source https://github.com/audetv/control-desk

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY ./ ./
