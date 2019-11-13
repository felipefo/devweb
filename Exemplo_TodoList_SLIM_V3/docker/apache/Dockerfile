FROM php:7.2-apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo_mysql
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

# Install composer:
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer	
	
WORKDIR /var/www/html/app_v1
RUN composer install