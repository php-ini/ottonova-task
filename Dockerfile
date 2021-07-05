FROM php:7.4-apache

RUN a2enmod rewrite
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

COPY . /var/www/html
WORKDIR /var/www/html

RUN chmod +x bin/console

# Install composer:
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN composer install

EXPOSE 80/tcp
EXPOSE 443/tcp