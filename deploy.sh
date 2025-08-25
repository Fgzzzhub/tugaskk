#!/bin/sh
set -e

echo "[deploy] PHP version:"
php -v || true

echo "[deploy] Composer platform check (abaikan kalau composer tidak tersedia di runtime):"
composer check-platform-reqs --no-dev || true

echo "[deploy] Clear & rebuild caches:"
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[deploy] Storage/bootstrap perms (best-effort):"
chmod -R 0775 storage bootstrap/cache || true

echo "[deploy] DB migrate (toleran error):"
php artisan migrate --force || true

echo "[deploy] Laravel about (info boot):"
php artisan about || true

echo "[deploy] DONE"
