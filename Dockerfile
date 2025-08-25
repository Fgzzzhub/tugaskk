# syntax=docker/dockerfile:1.7

########## Stage 1: Build/vendor ##########
FROM php:8.3-cli AS build

ENV TZ=UTC \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

# Paket yang dibutuhkan saat build (git, unzip/zip, libzip, intl)
# Cache APT dengan ID unik (prefiks stage)
RUN --mount=type=cache,id=build-apt-cache,target=/var/cache/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
      git unzip zip \
      libzip-dev zlib1g-dev \
      libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Ekstensi umum Laravel
RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j"$(nproc)" zip intl pdo pdo_mysql

# Composer dari image resmi
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Salin composer.* dulu agar cache efektif
COPY composer.json composer.lock ./

# Cache Composer dengan ID unik
RUN --mount=type=cache,id=build-composer-cache,target=/root/.composer/cache \
    composer install \
      --no-dev \
      --prefer-dist \
      --no-interaction \
      --optimize-autoloader \
      --classmap-authoritative

# Salin source aplikasi
COPY . .

# Optimalkan autoload lagi setelah semua file tersalin
RUN composer dump-autoload --optimize --classmap-authoritative


########## Stage 2: Runtime (Apache) ##########
FROM php:8.3-apache AS runtime

# Paket minimal runtime + cache APT
RUN --mount=type=cache,id=runtime-apt-cache,target=/var/cache/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
      libzip-dev zlib1g-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Ekstensi runtime
RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j"$(nproc)" zip intl pdo pdo_mysql

# Aktifkan mod_rewrite untuk Laravel
RUN a2enmod rewrite

# OPcache tuning (aman untuk produksi)
RUN { \
      echo 'opcache.enable=1'; \
      echo 'opcache.enable_cli=0'; \
      echo 'opcache.validate_timestamps=0'; \
      echo 'opcache.max_accelerated_files=20000'; \
      echo 'opcache.memory_consumption=192'; \
      echo 'opcache.interned_strings_buffer=16'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Document root ke public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN set -eux; \
    sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
      /etc/apache2/sites-available/000-default.conf \
      /etc/apache2/apache2.conf \
      /etc/apache2/conf-available/*.conf || true

WORKDIR /var/www/html

# Salin hasil build
COPY --from=build /app /var/www/html

# Permission untuk storage & cache
RUN chown -R www-data:www-data \
      /var/www/html/storage \
      /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
