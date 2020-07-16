FROM php:7.2.2-fpm

MAINTAINER Bruno Correia <brunogomescorreia@gmail.com>


COPY ./config/php.ini /usr/local/etc/php/php.ini


RUN apt-get update \
    && apt-get install -y vim git gettext \
			  r-base-core wget \ 
                          libcurl4-openssl-dev libssl-dev procps python3 python3-pip



RUN pip3 install keras==2.2.3 tensorflow pandas sklearn

RUN sed -i '/Using\ TensorFlow\ backend/d' /usr/local/lib/python3.5/dist-packages/keras/backend/__init__.py

# ZIP
RUN docker-php-ext-install zip


