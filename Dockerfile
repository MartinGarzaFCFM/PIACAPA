FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod dir
RUN echo 'DirectoryIndex index.php' > /etc/apache2/mods-enabled/dir.conf
RUN echo 'output_buffering = On' > /usr/local/etc/php/conf.d/custom.ini
COPY php.ini /usr/local/etc/php/php.ini
COPY . /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80
CMD ["apache2-foreground"]