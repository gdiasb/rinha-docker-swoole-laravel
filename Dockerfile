FROM php:8.2-fpm


WORKDIR /var/www/


RUN apt update && apt upgrade

RUN apt install -y libpq-dev git zip unzip curl

RUN docker-php-ext-install pdo_pgsql pgsql pcntl

# Swoole 
RUN pecl install swoole
RUN docker-php-ext-enable swoole


# Copy Laravel files to the container
COPY /www/ /var/www/

# Get composer and move compose.phar to usr/local/bin to call it globally
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer install

RUN composer require laravel/octane
RUN php artisan octane:install --server=swoole


CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=9000", "--log-level=debug"]