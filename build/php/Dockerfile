FROM php:7.2.2-fpm

MAINTAINER Bruno Correia <brunogomescorreia@gmail.com>

COPY config/php.ini /usr/local/etc/php/php.ini

#COPY config/Rscripts/mdp.R /usr/lib/mdp.R

#COPY config/Rscripts/install_mdp.R /install_mdp.R

#RUN apt-get update \
    && apt-get install -y r-base-core pandoc \
    libcurl4-openssl-dev libssl-dev \
    && Rscript /install_mdp.R

# ZIP
#RUN docker-php-ext-install zip
