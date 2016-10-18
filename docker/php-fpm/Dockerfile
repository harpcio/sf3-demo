FROM php:7.0-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \ 
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && apt-get install -y zlib1g-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install -j$(nproc) zip;
 
RUN useradd -ms /bin/bash vagrant

# timezone
RUN echo Europe/Warsaw > /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata

COPY php-fpm.conf /etc/php-fpm.conf

USER vagrant
 
WORKDIR /app