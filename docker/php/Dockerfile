FROM php:7.4-apache

RUN apt-get update -y --fix-missing
RUN apt-get upgrade -y

# Utilidades del sistema
RUN apt-get install -y nano wget git
RUN apt-get install -y curl libcurl4 libcurl4-gnutls-dev
RUN apt-get install -y zip zlib1g-dev


# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Other PHP7 Extensions
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json

# Enable apache modules
RUN a2enmod rewrite headers ssl

# Use the default production configuration
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
