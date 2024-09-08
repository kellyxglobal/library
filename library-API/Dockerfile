 FROM php:8.2 as php

 #Installing MYSQL
 RUN apt-get update -y
 RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
 RUN docker-php-ext-install pdo pdo_mysql bcmath

 #Installing Redis
 RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

#Setting Wok directory
WORKDIR /var/www
COPY . .

#Instaling composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint.sh" ]

# ===================================================
# Node
FROM node:14-alpine as node
WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME /var/www/nod_modules