FROM mysql:5.6 AS mysql
# ----------
FROM mongo:4.4 AS mongodb
# ----------

FROM php:8.1.0 AS php

# Install
RUN apt update && apt install -y \
    curl \
    default-mysql-client \
    git \
    libcurl4-openssl-dev \
    libssl-dev \
    netcat \
    pkg-config \
    unzip \
    vim \
    wget

# Install php extensions
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

# Install mongodb by pecl
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# ----------


FROM php AS php-xdebug

# Install xdebug by pecl
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
# ----------

FROM php:8.1.0-cli AS php-cli

# Install
RUN apt update && apt install -y \
    curl \
    git \
    libcurl4-openssl-dev \
    libssl-dev \
    netcat \
    pkg-config \
    unzip \
    vim \
    wget

# Install php extensions
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

# Install mongodb by pecl
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN usermod -u 1000 www-data
# ----------

FROM php-cli AS php-cli-pcov

# Install pcov by pecl
RUN pecl install pcov \
    && docker-php-ext-enable pcov
# ----------

FROM php-cli AS php-cli-xdebug

# Install xdebug by pecl
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
