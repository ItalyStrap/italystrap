ARG PHP_VERSION
ARG WP_VERSION

FROM wordpress:${WP_VERSION}-php${PHP_VERSION}

RUN  set -eux; \
     apt-get update && apt-get install -y \
     git \
     nano \
     less # Needed for the WP-CLI \
     rm -rf /var/lib/apt/lists/*

# Needed for Db driver
# https://github.com/Codeception/Codeception/issues/3605
RUN docker-php-ext-install \
    pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp
