FROM php:7.4-apache

# Actualizar y preparar el entorno de instalación
RUN apt-get update && apt-get install -y software-properties-common

# Añadir el repositorio de PHP ondrej para instalar otras versiones de PHP
RUN add-apt-repository ppa:ondrej/php

# Actualizar los repositorios nuevamente
RUN apt-get update

# Instalar Apache y habilitar módulos necesarios
RUN apt-get install -y apache2
RUN a2enmod rewrite  
RUN a2enmod headers

# Definir el directorio de trabajo
WORKDIR /var/www/html/php

# Instalar PHP 8.3 y las extensiones necesarias, incluyendo pdo_pgsql para PostgreSQL
RUN apt-get install -y php8.3 \
    php8.3-mysql \
    php8.3-cli \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-pcov \
    php8.3-xdebug \
    libpq-dev \
    php8.3-pgsql \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar el código fuente de la aplicación y los archivos de configuración de Apache
COPY . /var/www/html/php
COPY /Conexion/.envLocal /var/www/html/php/Conexion/.env
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ports.conf /etc/apache2/ports.conf

# Instalar Composer para la gestión de dependencias PHP
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Asignar los permisos correctos a los directorios y archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/php \
    && chmod -R 755 /var/www/html/php

# Ejecutar dump-autoload de Composer para optimizar el autoloading
RUN composer dump-autoload

# Exponer el puerto 80 para Apache
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2ctl", "-D", "FOREGROUND"]
