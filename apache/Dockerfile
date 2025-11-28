FROM httpd:2.4
COPY apache.conf /usr/local/apache2/conf/extra/php-fpm.conf
RUN echo "Include conf/extra/php-fpm.conf" >> /usr/local/apache2/conf/httpd.conf \
    && sed -i '/#LoadModule proxy_module/s/#//' /usr/local/apache2/conf/httpd.conf \
    && sed -i '/#LoadModule proxy_fcgi_module/s/#//' /usr/local/apache2/conf/httpd.conf
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
