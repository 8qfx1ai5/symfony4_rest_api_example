# this dockerfile is only for local development
# do not use this configuration for production systems

FROM php:7.2-apache
MAINTAINER Felix Ohnesorge <felix.ohnesorge@8qfx1ai5.de>

#COPY ./public-html/ /usr/local/apache2/htdocs/
#COPY ./my-httpd.conf /usr/local/apache2/conf/httpd.conf

# install xdebug extension
RUN pecl channel-update pecl.php.net \
;
RUN pecl -q install xdebug-2.6.0 \
;
# create an additionally php.ini file to load the xdebug extension
RUN echo 'zend_extension="'$(php-config --extension-dir)'/xdebug.so"' > /usr/local/etc/php/conf.d/xdebug.ini \
;

# install database plugins
RUN docker-php-ext-install mysqli pdo pdo_mysql \
;
