FROM php:7.2.2-fpm

MAINTAINER Thaís Ratis <thaisratis@gmail.com>


COPY ./config/php.ini /usr/local/etc/php/php.ini


RUN apt-get update \
    && apt-get install -y vim git gettext \
			  r-base-core wget \ 
                          libcurl4-openssl-dev libssl-dev procps

# DOWNLOAD SCRIPT ANACONDA
RUN curl https://repo.anaconda.com/archive/Anaconda3-2020.07-Linux-x86_64.sh --output /opt/Anaconda3-2020.07-Linux-x86_64.sh
RUN chmod +x /opt/Anaconda3-2020.07-Linux-x86_64.sh

RUN /opt/Anaconda3-2020.07-Linux-x86_64.sh -b -p /usr/local/anaconda3

RUN rm /opt/Anaconda3-2020.07-Linux-x86_64.sh

RUN /usr/local/anaconda3/bin/conda install -y -c conda-forge xgboost

RUN /usr/local/anaconda3/bin/conda install -y -c conda-forge biopython


# ZIP
RUN docker-php-ext-install zip


