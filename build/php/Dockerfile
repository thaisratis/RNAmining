FROM php:7.2.2-fpm

MAINTAINER Bruno Correia <brunogomescorreia@gmail.com>

COPY ./files/deploy-config.php /tmp

COPY ./config/php.ini /usr/local/etc/php/php.ini

COPY ./ssh-keys/key-metavolcano /var/www/.ssh/id_rsa

RUN chown 33:33 -R /var/www/.ssh/

#COPY config/Rscripts/mdp.R /usr/lib/mdp.R

#COPY config/Rscripts/install_mdp.R /install_mdp.R

RUN apt-get update \
    && apt-get install -y vim git gettext
#    && apt-get install -y r-base-core pandoc \
#    libcurl4-openssl-dev libssl-dev \
#    && Rscript /install_mdp.R

# ZIP
#RUN docker-php-ext-install zip

RUN ssh-keyscan gitlab.com > /var/www/.ssh/known_hosts
