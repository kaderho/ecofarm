FROM php:8.1.3-fpm-alpine3.15

ENV NGINX_VERSION 1.20.2
ENV NJS_VERSION   0.7.0
ENV PKG_RELEASE   1

# install necessary alpine packages
RUN apk update && apk add --no-cache \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    $PHPIZE_DEPS \
    libjpeg-turbo-dev \
    imagemagick-dev imagemagick

# compile native PHP packages
RUN docker-php-ext-install \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql

# configure packages
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# install additional packages from PECL
RUN pecl install zip && docker-php-ext-enable zip \
    && pecl install igbinary && docker-php-ext-enable igbinary \
    && yes | pecl install redis && docker-php-ext-enable redis

# imagick
RUN apk add --update --no-cache autoconf g++ imagemagick imagemagick-dev libtool make pcre-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf g++ libtool make pcre-dev

# install nginx
RUN set -x \
    && nginxPackages=" \
    nginx=${NGINX_VERSION}-r${PKG_RELEASE} \
    nginx-module-xslt=${NGINX_VERSION}-r${PKG_RELEASE} \
    nginx-module-geoip=${NGINX_VERSION}-r${PKG_RELEASE} \
    nginx-module-image-filter=${NGINX_VERSION}-r${PKG_RELEASE} \
    nginx-module-njs=${NGINX_VERSION}.${NJS_VERSION}-r${PKG_RELEASE} \
    " \
    set -x \
    && KEY_SHA512="e7fa8303923d9b95db37a77ad46c68fd4755ff935d0a534d26eba83de193c76166c68bfe7f65471bf8881004ef4aa6df3e34689c305662750c0172fca5d8552a *stdin" \
    && apk add --no-cache --virtual .cert-deps \
    openssl \
    && wget -O /tmp/nginx_signing.rsa.pub https://nginx.org/keys/nginx_signing.rsa.pub \
    && if [ "$(openssl rsa -pubin -in /tmp/nginx_signing.rsa.pub -text -noout | openssl sha512 -r)" = "$KEY_SHA512" ]; then \
    echo "key verification succeeded!"; \
    mv /tmp/nginx_signing.rsa.pub /etc/apk/keys/; \
    else \
    echo "key verification failed!"; \
    exit 1; \
    fi \
    && apk del .cert-deps \
    && apk add -X "https://nginx.org/packages/alpine/v$(egrep -o '^[0-9]+\.[0-9]+' /etc/alpine-release)/main" --no-cache $nginxPackages

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# set composer related environment variables
ENV PATH="/composer/vendor/bin:$PATH" \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_VENDOR_DIR=/var/www/vendor \
    COMPOSER_HOME=/composer

# copy supervisor configuration
COPY ./docker/supervisord.conf /etc/supervisord.conf

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --ansi --version --no-interaction

# install application dependencies
WORKDIR /var/www/app

COPY . .
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction

RUN php artisan migrate:fresh
RUN php artisan cache:clear
RUN php artisan route:cache

# add custom php-fpm pool settings, these get written at entrypoint startup
ENV FPM_PM_MAX_CHILDREN=20 \
    FPM_PM_START_SERVERS=2 \
    FPM_PM_MIN_SPARE_SERVERS=1 \
    FPM_PM_MAX_SPARE_SERVERS=3

# set application environment variables
ENV APP_NAME="Eco Farm" \
    APP_ENV=production \
    APP_DEBUG=false

# copy entrypoint files
# COPY ./docker/docker-php-entrypoint /usr/local/bin/
# RUN dos2unix /usr/local/bin/docker-php-entrypoint
# RUN dos2unix /usr/local/bin/docker-php-entrypoint-dev

# copy nginx configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/default.conf /etc/nginx/conf.d/default.conf
# COPY ./docker/default.conf /etc/nginx/sites-available/default.conf

# RUN service restart nginx

# # copy application code
# WORKDIR /var/www/app
# COPY . .
RUN composer dump-autoload -o \
    && chown -R :www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

EXPOSE 80

# run supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

