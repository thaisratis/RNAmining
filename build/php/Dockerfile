FROM php:7.2.2-fpm

MAINTAINER Bruno Correia <brunogomescorreia@gmail.com>

COPY ./files/deploy-config.php /tmp

COPY ./config/php.ini /usr/local/etc/php/php.ini

COPY ./ssh-keys/key-metavolcano /var/www/.ssh/id_rsa

RUN chmod 400 /var/www/.ssh/id_rsa

RUN chown 33:33 -R /var/www/.ssh/

COPY ./config/Rscripts/install_prereq.R /install_prereq.R

RUN apt-get update \
    && apt-get install -y vim git gettext \
			  r-base-core wget \ 
                          libcurl4-openssl-dev libssl-dev procps

RUN Rscript /install_prereq.R

RUN cd /usr/local/src/

RUN git clone https://github.com/jgm/pandoc

RUN cd pandoc

RUN git submodule update --init

RUN curl -sSL https://get.haskellstack.org/ | sh

RUN /usr/local/bin/stack setup

RUN /usr/local/bin/stack install

RUN mv /root/.local/bin/pandoc /usr/local/bin/

# ZIP
RUN docker-php-ext-install zip

RUN ssh-keyscan gitlab.com > /var/www/.ssh/known_hosts
