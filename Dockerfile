FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod dir
RUN echo 'DirectoryIndex index.php' > /etc/apache2/mods-enabled/dir.conf
RUN echo 'output_buffering = On' > /etc/apache2/conf-available/custom-output-buffering.conf \
    && a2enconf custom-output-buffering
COPY . /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80
CMD ["apache2-foreground"]