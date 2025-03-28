FROM php:8.3.7
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y\
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    openssh-client\
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl
    
RUN mkdir -p /root/.ssh && chmod 700 /root/.ssh

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring soap bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN   mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

#Scarico da github ufficiale il file debian per buster della versione 0.12.6
RUN curl -L#o wkhtmltopdf.deb https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.buster_amd64.deb
RUN dpkg -i wkhtmltopdf.deb; apt-get install -y -f

RUN apt-get clean all \
    && rm -rvf /var/lib/apt/lists/*

WORKDIR /var/www/symfony


CMD ["symfony", "server:start",  "--allow-all-ip"]