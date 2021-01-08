FROM php:7.2-fpm-alpine

COPY . .

RUN rm -rf /var/www/html/logs/* \
    && chown -R www-data:www-data /var/www/html

RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql

RUN apk --update --no-cache add autoconf g++ make && \
    pecl install -f xdebug && \
    docker-php-ext-enable xdebug && \
    apk del --purge autoconf g++ make

RUN cp ./docker/conf/php/php.ini "$PHP_INI_DIR/php.ini"
