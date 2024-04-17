FROM php:8.1-apache

RUN apt-get -y update
RUN apt-get -y install libzip-dev zip unzip libsodium-dev libxslt1-dev openssh-server libfreetype6-dev libcurl4-openssl-dev libssl-dev curl

RUN docker-php-ext-install pdo_mysql sodium zip sockets curl
RUN docker-php-ext-install pcntl

RUN pecl update-channels
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install pecl_http && docker-php-ext-enable http
RUN pecl install redis && docker-php-ext-enable redis

RUN a2enmod rewrite
RUN apt-get upgrade -y

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* && \
    apt-get remove -y libxslt1-dev icu-devtools libicu-dev libxml2-dev && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update