FROM php:7.2-apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo_mysql
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv /composer.phar /usr/local/bin/composer	
	
WORKDIR /var/www/html/app_v1
RUN composer install