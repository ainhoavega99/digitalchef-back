FROM ubuntu:20.04

RUN apt-get update && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update


RUN apt-get install -y apache2 \
&& apt-get install -y mysql-server \
RUN a2enmod rewrite  
RUN a2enmod headers

WORKDIR /var/www/html/php

RUN apt-get install -y php8.3
RUN apt-get install -y mysql-server
RUN apt-get install -y php8.3-mysql \
    php8.3-cli \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-pcov \
    php8.3-xdebug

COPY . /var/www/html/php
COPY /Conexion/.envLocal /var/www/html/php/Conexion/.env
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
# COPY php.conf /etc/apache2/sites-available/php.conf
COPY ports.conf /etc/apache2/ports.conf

# COPY --from=digitalchef-angular:latest /usr/src/dist /var/www/html/dist

# Set MySQL environment variables
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=MENU
ENV MYSQL_USER=usuario
ENV MYSQL_PASSWORD=usuario

# Copy the SQL script to initialize the database
COPY ./mysql/MENU.sql /docker-entrypoint-initdb.d/

# Install Composer for PHP dependency management
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/php \
    && chmod -R 755 /var/www/html/php

# Dump Composer autoload
RUN composer dump-autoload

# Expose Apache and MySQL ports
EXPOSE 80 3306

# Initialize the MySQL database and Apache
RUN service mysql start && mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "CREATE DATABASE ${MYSQL_DATABASE};" \
    && mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "CREATE USER '${MYSQL_USER}'@'localhost' IDENTIFIED BY '${MYSQL_PASSWORD}';" \
    && mysql -uroot -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE}.* TO '${MYSQL_USER}'@'localhost';" \
    && mysql -uroot -p${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} < /docker-entrypoint-initdb.d/MENU.sql

# Command to start MySQL and Apache together
CMD service mysql start && apache2ctl -D FOREGROUND