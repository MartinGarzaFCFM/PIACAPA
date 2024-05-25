FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql exif
RUN a2enmod dir
RUN echo 'DirectoryIndex index.php' > /etc/apache2/mods-enabled/dir.conf
RUN echo 'file_uploads = On' >> /usr/local/etc/php/php.ini
RUN echo 'upload_max_filesize = 40M' >> /usr/local/etc/php/php.ini
RUN echo 'post_max_size = 20M' >> /usr/local/etc/php/php.ini
RUN echo 'output_buffering = On' >> /usr/local/etc/php/php.ini
COPY . /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80
CMD ["apache2-foreground"]