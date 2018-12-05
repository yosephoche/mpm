FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.2-mysql php7.2-pgsql php-redis php7.2-sqlite3 php-xdebug php7.2-gd php-imagick php7.2-imap php-mongodb php7.2-phpdbg php7.2-soap php-ssh2 php-yaml php7.2-gmp php7.2-intl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# #GMP
# RUN apt-get update -y \ 
#     && apt-get install -y libgmp-dev re2c libmhash-dev libmcrypt-dev file \
#     && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
#     && docker-php-ext-configure gmp \
#     && docker-php-ext-install gmp

# RUN apt-get update --fix-missing
# RUN apt-get install -y autoconf pkg-config libssl-dev
# RUN pecl install mongodb-1.2.2
# RUN docker-php-ext-install bcmath
# RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

RUN apt-get update \
    && apt-get install -y zlib1g-dev libicu-dev g++ \