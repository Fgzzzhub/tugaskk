# ===== Stage 1: build vendor dengan composer =====
FROM composer:2 AS vendor
WORKDIR /app

# Salin file composer dulu supaya caching layer efektif
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# ===== Stage 2: runtime PHP + Apache =====
FROM php:8.2-apache

# OS tools yg dibutuhkan Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
      unzip zip git libzip-dev \
  && rm -rf /var/lib/apt/lists/*

# Ekstensi PHP
RUN docker-php-ext-configure zip \
 && docker-php-ext-install zip pdo pdo_mysql

# Aktifkan mod_rewrite dan set DocumentRoot ke public/
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!DocumentRoot /var/www/html!DocumentRoot ${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's!<Directory /var/www/html>!<Directory ${APACHE_DOCUMENT_ROOT}>!g' /etc/apache2/apache2.conf

# Salin source code
WORKDIR /var/www/html
COPY . .

# Salin vendor hasil stage composer
COPY --from=vendor /app/vendor ./vendor

# Permission untuk storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache

# NOTE: Jangan jalankan artisan saat build (butuh APP_KEY/DB). Jalankan saat runtime via Railway.
EXPOSE 80
