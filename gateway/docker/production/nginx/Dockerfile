FROM nginx:1.23-alpine

LABEL org.opencontainers.image.source https://github.com/audetv/control-desk

COPY ./common/nginx/snippets /etc/nginx/snippets
COPY ./production/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app
