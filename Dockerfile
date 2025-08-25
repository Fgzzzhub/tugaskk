# ===== Stage 1: Build (Composer + ekstensi dev yang diperlukan untuk build) =====
FROM php:8.3-cli AS build

# Pastikan locale & tz opsional
ENV TZ=UTC
# Hindari kehabisan memori saat install dependency besar
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

# Paket OS yang dibutuhkan Composer & ekstensi PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip \
    libzip-dev zlib1g-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Ekstensi yang umum dipakai Laravel
RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j$(nproc) zip intl pdo pdo_mysql

# Ambil Composer dari image resmi
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Salin composer.* dulu agar cache efektif
COPY composer.json composer.lock ./

# Aktifkan cache untuk vendor (butuh BuildKit)
# docker buildx/buildkit akan otomatis mengisi mount cache di bawah ini
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install \
      --no-dev \
      --prefer-dist \
      --no-interaction \
      --optimize-autoloader \
      --classmap-authoritative

# Setelah vendor siap, salin seluruh source
COPY . .

# Opsi: jalankan kembali dump-autoload agar classmap include file baru
RUN composer dump-autoload --optimize --classmap-authoritative

# ===== Stage 2: Runtime (Apache) =====
FROM php:8.3-apache AS runtime

# Paket OS minimum + ekstensi runtime saja
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev zlib1g-dev libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure zip \
 && docker-php-ext-install -j$(nproc) zip intl pdo pdo_mysql

# Aktifkan mod_rewrite untuk Laravel
RUN a2enmod rewrite

# (Opsional tapi disarankan) sedikit tuning OPcache
RUN { \
      echo 'opcache.enable=1'; \
      echo 'opcache.enable_cli=0'; \
      echo 'opcache.validate_timestamps=0'; \
      echo 'opcache.max_accelerated_files=20000'; \
      echo 'opcache.memory_consumption=192'; \
      echo 'opcache.interned_strings_buffer=16'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Set document root jika pakai public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf || true

WORKDIR /var/www/html

# Salin hasil build dari stage sebelumnya
COPY --from=build /app /var/www/html

# Permission sederhana
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
