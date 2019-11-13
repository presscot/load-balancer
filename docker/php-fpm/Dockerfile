FROM php:7.3-fpm-alpine

COPY tools/docker-php-pecl-install.sh /usr/local/bin/docker-php-pecl-install
COPY tools/cmd.sh /usr/local/bin/cmd
RUN chmod +x /usr/local/bin/cmd

COPY php.ini "${PHP_INI_DIR}/"

RUN apk add --no-cache --update  \
    sudo \
    icu \
    curl \
    nano \
    bash \
    git \
    zip \
    unzip \
    libpng \
    libmemcached-libs \
    zlib \
    openssl \
    libzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PHP_CONFIG " /usr/local/bin/php-config"

RUN set -xe && \
    cd /tmp/ && \
    apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS && \
    apk add --no-cache --update --virtual .memcached-deps zlib-dev libmemcached-dev cyrus-sasl-dev && \
    apk add --no-cache --update --virtual .deps libpng-dev icu-dev openssl-dev zlib-dev libzip-dev && \
# Install igbinary (memcached's deps)
    docker-php-pecl-install \
        intl \
        opcache \
        gd \
        bcmath \
        zip \
        pcntl \
        ## \
        igbinary \
        mongodb \
        ## \
        memcached --enable-memcached-igbinary \
        apcu --enable-apcu-debug=no \
#        lzf --enable-lzf-better-compression=yes \
        redis --enable-redis-igbinary=yes --enable-redis-lzf=yes \
    && \
# Enable PHP extensions
    rm -rf /tmp/* && \
    apk del .memcached-deps .phpize-deps .deps


RUN rm -f /etc/php-fpm.conf

ADD php-fpm.conf /etc/php-fpm.conf
ADD entrypoint.sh /entrypoint.sh

RUN chmod +x /etc/php-fpm.conf
RUN chmod +x /entrypoint.sh

EXPOSE 9000

WORKDIR /var/www

ENTRYPOINT ["/entrypoint.sh"]