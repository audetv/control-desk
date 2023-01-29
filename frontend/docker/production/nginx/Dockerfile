FROM nginx:1.23-alpine

LABEL org.opencontainers.image.source https://github.com/audetv/control-desk

COPY ./docker/common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY ./public ./public
