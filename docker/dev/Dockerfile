# this dockerfile is only for local development
# do not use this configuration for production systems

FROM php:7.2
MAINTAINER Felix Ohnesorge <felix.ohnesorge@8qfx1ai5.de>

# package update
RUN apt-get update

# install apt-utils (workaround to omit errors)
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y --no-install-recommends apt-utils

# install wget
RUN apt-get install wget

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# hack for home directory (@todo create new user)
RUN mkdir /var/www ; \
    chmod -R a+rwx /var/www

# install git for composer
RUN apt-get --assume-yes install git

# install zip for composer
RUN apt-get --assume-yes install zip unzip

USER www-data
