FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
WORKDIR /var/www/html/
RUN echo 'DirectoryIndex Home.php' > /etc/apache2/conf-available/custom-directory-index.conf \
    && a2enconf custom-directory-index
EXPOSE 80
CMD ["apache2-foreground"]