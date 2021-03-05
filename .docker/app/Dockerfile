FROM php:7.4-apache
# RUN rm /etc/apt/preferences.d/no-debian-php
RUN apt-get update

RUN apt-get install -y openssl

RUN set -x \
    && apt-get install -y git \
    && git --version && bash --version && ssh -V 
RUN chmod o+r /etc/resolv.conf
RUN echo "nameserver 8.8.8.8" | tee /etc/resolv.conf > /dev/null
# RUN apt-get update && apt-get install -y apt-transport-https --fix-missing
#   mysql-client \
RUN apt-get update && apt-get install -y --fix-missing \
    apt-utils \
    wget \
    vim \
    zip \
    ftp \
    gnupg
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libgmp-dev  \
    libssh2-1-dev\
    libssh2-1\
    libfreetype6-dev
RUN pecl install ssh2-1.2

RUN docker-php-ext-enable ssh2
RUN docker-php-ext-install intl zip soap bcmath
# mysqli, pdo, pdo_mysql, pdo_pgsql
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN pecl install mcrypt-1.0.3
RUN docker-php-ext-enable mcrypt
# mcrypt, gd, iconv
#RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
#    && docker-php-ext-configure gd \
#    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" gd

# gmp
RUN apt-get -y install  \
    && docker-php-ext-install gmp

##


ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz


WORKDIR /var/www
# RUN rm -rf /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN mysql -u root -proot -e "create database db_max"; 
# RUN composer install && \
#                 cp .env.example .env && \
#                 php artisan key:generate && \
#                 php artisan config:cache
RUN a2enmod rewrite
RUN a2enmod headers
# COPY . /var/www
# RUN ln -s public html
EXPOSE 80
ENTRYPOINT ["php-fpm"]