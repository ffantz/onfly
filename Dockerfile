FROM php:8.1-fpm

WORKDIR /var/www/html

# Instalação de dependencias
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip zip \
        libicu-dev \
        libpng-dev \
        wget \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql gd intl

# Entrypoint
# COPY ./docker-entrypoint.sh /docker-entrypoint.sh
# RUN chmod +x /docker-entrypoint.sh

# Instala a ferramenta para criar dependencia entre
ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# Instalação do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer require predis/predis

# Expor a porta 8000
EXPOSE 8000