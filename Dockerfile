FROM php:8.0-fpm-alpine

RUN apk add --no-cache --virtual \
    .build-deps \
    $PHPIZE_DEPS \
    bash \
    freetype-dev \
    git \
    icu-dev \
    icu-libs \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    mysql-client \
    oniguruma-dev \
    openssh-client \
    openssl \
    postgresql-dev \
    rsync \
    zlib-dev

# Configure php extensions.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install php extensions.
RUN docker-php-ext-install \
    bcmath \
    calendar \
    exif \
    gd \
    intl \
    pdo_mysql \
    pdo_pgsql \
    pcntl \
    zip

# Install composer.
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# Add user and group.
RUN addgroup -S -g 1000 www
RUN adduser -S -u 1000 -s /bin/bash -G www www

# Setup working directory.
WORKDIR /app
COPY --chown=www:www . /app

# Install dependencies.
RUN composer install --optimize-autoloader --no-dev

# Change current user to www.
USER www

# Expose port 9000 and start php-fpm server.
EXPOSE 9000
CMD ["php-fpm"]
