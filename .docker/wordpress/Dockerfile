ARG PHP_VERSION
ARG WP_VERSION

FROM wordpress:${WP_VERSION}-php${PHP_VERSION}

# Install pcov for code coverage
RUN set -eux; \
    pecl install pcov; \
    docker-php-ext-enable pcov

# If you want to use xdebug, uncomment the following lines
# Install xdebug for code coverage
#RUN set -eux; \
#    pecl install xdebug-3.1.4; \
#    docker-php-ext-enable xdebug

# Set XDEBUG_MODE=coverage or xdebug.mode=coverage
#ENV XDEBUG_MODE=coverage

RUN  set -eux; \
     apt-get update && apt-get install -y \
     git \
     nano \
     less # Needed for the WP-CLI \
     rm -rf /var/lib/apt/lists/*

# Git add safe directory for the working directory


# Needed for Db driver
# https://github.com/Codeception/Codeception/issues/3605
RUN docker-php-ext-install \
    pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp
