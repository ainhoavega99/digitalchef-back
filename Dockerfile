FROM ubuntu:20.04

RUN apt-get update && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN apt-get install -y apache2
RUN a2enmod rewrite  
RUN a2enmod headers

WORKDIR /var/www/html/php

RUN apt-get install -y php8.3
RUN apt-get install -y php8.3-mysql \
    php8.3-cli \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-pcov \
    php8.3-xdebug

COPY . /var/www/html/php
COPY /Conexion/.envLocal /var/www/html/php/Conexion/.env
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY php.conf /etc/apache2/sites-available/php.conf
COPY ports.conf /etc/apache2/ports.conf

COPY --from=digitalchef-angular:latest /usr/src/dist /var/www/html/dist

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/php \
    && chmod -R 755 /var/www/html/php

RUN composer dump-autoload

RUN a2ensite php.conf

EXPOSE 80 82

# Iniciar Apache en primer plano
CMD ["apache2ctl", "-D", "FOREGROUND"]