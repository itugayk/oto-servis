#!/usr/bin/env bash
set -e

cd /var/www/html

echo "==> OtoPro: initialising application"

# Ensure an application key exists (Coolify normally injects APP_KEY).
if [ -z "${APP_KEY}" ] && ! grep -q "^APP_KEY=base64" .env 2>/dev/null; then
    php artisan key:generate --force || true
fi

# SQLite database file (only relevant when DB_CONNECTION=sqlite).
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    mkdir -p "$(dirname "$DB_FILE")"
    [ -f "$DB_FILE" ] || touch "$DB_FILE"
fi

# Symlink public/storage -> storage/app/public
php artisan storage:link || true

# Run migrations and (idempotent) seeders.
php artisan migrate --force --seed || php artisan migrate --force

# Cache config / routes / views for production performance.
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> OtoPro: ready"
