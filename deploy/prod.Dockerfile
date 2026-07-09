# ─── Stage 1: Build frontend assets ────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app
COPY src/package*.json ./
RUN npm ci
COPY src/ .
RUN npm run build

# ─── Stage 2: Production PHP image (FrankenPHP native — no Octane) ───────────
FROM dunglas/frankenphp:php8.3-alpine

RUN apk add --no-cache bash curl libpng-dev libjpeg-turbo-dev freetype-dev \
    zip unzip icu-dev oniguruma-dev libzip-dev

RUN install-php-extensions \
    pdo_mysql \
    redis \
    intl \
    opcache \
    gd \
    zip \
    bcmath \
    pcntl \
    sockets

RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.memory_consumption=256"; \
    echo "opcache.max_accelerated_files=20000"; \
    echo "opcache.validate_timestamps=0"; \
    echo "opcache.interned_strings_buffer=16"; \
} > /usr/local/etc/php/conf.d/opcache-prod.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# ── Dependency layer (cached until composer files change) ────────────────────
# --no-scripts/--no-autoloader: skips artisan/autoload-file steps that need
# app/ source (e.g. app/helpers.php), which isn't copied in yet.
COPY src/composer.json src/composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --no-progress

# ── Application source ────────────────────────────────────────────────────────
COPY src/ .
COPY --from=frontend /app/public/build ./public/build

# ── Finish install now that app/ source (incl. helpers.php) is present ───────
# dump-autoload auto-triggers the post-autoload-dump script (package:discover,
# filament:upgrade) defined in composer.json.
RUN composer dump-autoload --no-dev --optimize --no-interaction

# ── Caddyfile ─────────────────────────────────────────────────────────────────
COPY deploy/Caddyfile /etc/caddy/Caddyfile

RUN mkdir -p storage/app/public storage/framework/{cache,sessions,views} storage/logs \
    && chown -R www-data:www-data /app \
    && chmod -R 755 storage bootstrap/cache

COPY deploy/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

EXPOSE 80 443 443/udp

HEALTHCHECK --interval=30s --timeout=5s --start-period=40s \
    CMD curl -f http://localhost/up || exit 1

USER www-data

CMD ["/usr/local/bin/start"]
