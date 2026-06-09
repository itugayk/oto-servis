# syntax=docker/dockerfile:1

# ----------------------------------------------------------------------------
# Stage 1 — PHP dependencies (Composer)
# ----------------------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-scripts --no-autoloader \
    --prefer-dist --no-interaction --ignore-platform-reqs

# ----------------------------------------------------------------------------
# Stage 2 — Frontend assets (Vite / Tailwind)
# ----------------------------------------------------------------------------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
# Vendor blade files are referenced by Tailwind @source globs (pagination, etc.)
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

# ----------------------------------------------------------------------------
# Stage 3 — Runtime (PHP-FPM + Nginx, single container)
# ----------------------------------------------------------------------------
FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off \
    AUTORUN_ENABLED=false

USER root

WORKDIR /var/www/html

# Application source
COPY --chown=www-data:www-data . .

# Dependencies + built assets from earlier stages
COPY --chown=www-data:www-data --from=vendor /app/vendor ./vendor
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

# Optimise the autoloader and discover packages now that the full app is present
RUN composer dump-autoload --optimize --no-interaction \
    && php artisan package:discover --ansi

# Startup script: prepare SQLite, migrate, seed, cache, link storage
COPY docker/entrypoint.d/ /etc/entrypoint.d/
RUN chmod +x /etc/entrypoint.d/*.sh \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs database \
    && chown -R www-data:www-data storage bootstrap/cache database

USER www-data
