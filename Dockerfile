FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo_mysql mysqli pdo

RUN a2enmod rewrite

RUN chmod 777 -R -c /var/www

RUN curl --silent --show-error https://getcomposer.org/installer | php \
   &&  mv composer.phar /usr/local/bin/composer