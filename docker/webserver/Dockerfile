# this dockerfile is only for local development
# do not use this configuration for production systems

FROM php:7.2-apache
MAINTAINER Felix Ohnesorge <felix.ohnesorge@8qfx1ai5.de>

# install database plugins
RUN docker-php-ext-install mysqli pdo pdo_mysql

# install xdebug extension
RUN pecl channel-update pecl.php.net ; \
    pecl -q install xdebug-2.6.0

# create an additionally php.ini file to load the xdebug extension
RUN echo 'zend_extension="'$(php-config --extension-dir)'/xdebug.so"' > /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.idekey = "PHPSTORM"' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.remote_port = 9000' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.remote_enable = 1' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.remote_autostart = on' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.connect_back = 1' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.profiler_output_dir = "/var/www/html"' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.profiler_enable = 0' >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    echo 'xdebug.remote_handler = dbgp' >> /usr/local/etc/php/conf.d/xdebug.ini

# configure apache2
RUN sed -i -- 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/public/g' /etc/apache2/sites-available/000-default.conf
