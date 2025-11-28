FROM php:8.3-fpm
RUN apt-get update && apt-get install -y default-libmysqlclient-dev \
    && docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
