FROM nginx:1.23-alpine

COPY ./conf.d /etc/nginx/conf.d

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

WORKDIR /app
