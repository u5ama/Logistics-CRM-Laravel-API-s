########################
# SSL CERT BUILD
########################

FROM alpine as encrypt

WORKDIR /certs

ENV SSL_CERT "ssl-cert-snakeoil.pem"
ENV SSL_KEY "ssl-cert-snakeoil.key"

COPY .docker/build/apache/bin/generate-certs.sh /usr/local/bin/generate-certs.sh

RUN apk --update add bash openssl

RUN chmod +x /usr/local/bin/generate-certs.sh \
  && /usr/local/bin/generate-certs.sh

########################
# PHP COMPOSER BUILD
########################

FROM php:8.1-apache as backend

RUN apt-get update && apt-get install -y \
  nano git libzip-dev zip \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
  && docker-php-ext-configure zip \
  && docker-php-ext-configure bcmath \
  && docker-php-ext-install -j$(nproc) zip \
  && docker-php-ext-install -j$(nproc) bcmath \
  && docker-php-ext-install -j$(nproc) sockets \
  && docker-php-ext-install -j$(nproc) gd

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app

COPY . /app

RUN composer install --no-ansi --no-autoloader --no-interaction --no-scripts
RUN composer dump-autoload --optimize --classmap-authoritative

########################
# APACHE/PHP SERVER BUILD
########################

FROM php:8.1-apache AS apache


ENV TZ "Australia/Melbourne"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY .docker/build/apache/php/php.ini /usr/local/etc/php/

COPY .docker/build/apache/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/build/apache/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

RUN ln -sf /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf
RUN ln -sf /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf

COPY --from=encrypt /certs /etc/ssl/certs/

RUN mkdir -p /usr/share/man/man1

RUN apt-get update && apt-get install -y \
  nano git zip \
  nfs-common \
  net-tools \
  libssl-dev imagemagick \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libxml2-dev \
  libzip-dev \
  libfontconfig \
  libxrender1 \
  libxtst6 \
  libgmp-dev \
#  pdftk \
  zlib1g-dev \
  wget
RUN docker-php-ext-install -j$(nproc) iconv \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
  && docker-php-ext-install -j$(nproc) sockets \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-configure bcmath \
  && docker-php-ext-install -j$(nproc) bcmath \
  && docker-php-ext-install -j$(nproc) gmp \
  && docker-php-ext-install -j$(nproc) soap \
  && docker-php-ext-install -j$(nproc) zip \
  && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

WORKDIR /var/www/html

COPY --from=backend /app /var/www/html

RUN a2enmod rewrite \
  && a2enmod ssl

RUN [ -d /var/www/html/storage ] || mkdir /var/www/html/storage \
  && [ -d /var/www/html/storage/logs ] || mkdir /var/www/html/storage/logs \
  && [ -d /var/www/html/storage/framework ] || mkdir /var/www/html/storage/framework \
  && [ -d /var/www/html/storage/framework/cache ] || mkdir /var/www/html/storage/framework/cache \
  && [ -d /var/www/html/storage/framework/cache/data ] || mkdir /var/www/html/storage/framework/cache/data \
  && [ -d /var/www/html/storage/framework/session ] || mkdir /var/www/html/storage/framework/session \
  && [ -d /var/www/html/storage/framework/sessions ] || mkdir /var/www/html/storage/framework/sessions \
  && [ -d /var/www/html/storage/framework/views ] || mkdir /var/www/html/storage/framework/views \
  && [ -d /var/www/html/storage/app ] || mkdir /var/www/html/storage/app \
  && [ -d /var/www/html/storage/app/bundles ] || mkdir /var/www/html/storage/app/bundles \
  && [ -d /var/www/html/storage/app/bundles/expand ] || mkdir /var/www/html/storage/app/bundles/expand \
  && [ -d /var/www/html/storage/app/bundles/zip ] || mkdir /var/www/html/storage/app/bundles/zip \
  && [ -d /var/www/html/storage/temp ] || mkdir /var/www/html/storage/temp

RUN chgrp -R www-data /var/www/html \
  && chmod -R ug+rwx /var/www/html \
    && chown -R root:www-data /var/www/html/storage/framework \
    && chmod -R 777 /var/www/html/storage

RUN ln -s /var/www/html/storage/ /var/www/html/public/storage

COPY .docker/build/apache/start.sh /usr/local/bin/start

ARG version=development
ENV VERSION $version

CMD ["/usr/local/bin/start"]
