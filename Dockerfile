FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    nano \
    less \
    libxml2-dev \
    zlib1g-dev \
    libicu-dev \
    libonig-dev \
    libxslt1-dev \
    libzip-dev

RUN docker-php-ext-install \
    intl \
    mysqli \
    pdo_mysql \
    xsl \
    zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/local/bin/composer