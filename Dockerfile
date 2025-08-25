# syntax=docker/dockerfile:1.7

########## Stage 1: Build/vendor ##########
FROM php:8.3-cli AS build

ENV TZ=UTC \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

# Paket OS untuk build
RUN --mount=type=cache,id=build-cache-apt,target=/var/cache/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
      git unzip zip libzip-dev zlib1g-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Ekstensi
RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j"$(nproc)" zip intl pdo pdo_mysql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./

# Cache composer dengan id prefiks "build-cache-"
RUN --mount=type=cache,id=build-cache-composer,target=/root/.composer/cache \
    composer install \
      --no-dev --prefer-dist --no-interaction \
      --optimize-autoloader --classmap-authoritative

COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative


########## Stage 2: Runtime ##########
FROM php:8.3-apache AS runtime

RUN --mount=type=cache,id=runtime-cache-apt,target=/var/cache/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
      libzip-dev zlib1g-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j"$(nproc)" zip intl pdo pdo_mysql

RUN a2enmod rewrite
# OPcache optimasi, dsb...

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
      /etc/apache2/sites-available/000-default.conf \
      /etc/apache2/apache2.conf \
      /etc/apache2/conf-available/*.conf || true

WORKDIR /var/www/html
COPY --from=build /app /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
