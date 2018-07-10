FROM nginx

MAINTAINER Bruno Correia <brunogomescorreia@gmail.com>

COPY ./config/nginx.conf /etc/nginx/nginx.conf

COPY ./config/metavolcano.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html/
