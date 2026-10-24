FROM node:20-bookworm-slim AS node
FROM composer:2.8 AS composer
FROM php:8.4-cli-bookworm

ARG WWWGROUP=1000
ARG WWWUSER=1000

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        libicu-dev libonig-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath exif gd intl mbstring pcntl pdo_mysql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && groupadd --gid "$WWWGROUP" sail \
    && useradd --uid "$WWWUSER" --gid sail --create-home --shell /bin/bash sail \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

WORKDIR /var/www/html
USER sail

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public", "server.php"]
