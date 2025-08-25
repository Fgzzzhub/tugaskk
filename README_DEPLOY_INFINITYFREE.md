# Deploy Laravel 12 ke InfinityFree (tanpa SSH)

## 1) Siapkan di lokal
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate     # opsional (uji lokal)
php artisan storage:link || true
php artisan config:cache && php artisan route:cache && php artisan view:cache
composer install --no-dev --optimize-autoloader
