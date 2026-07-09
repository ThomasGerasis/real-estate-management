#!/bin/sh
set -e

echo "==> Running storage:link..."
php artisan storage:link --force --quiet 2>/dev/null || true

echo "==> Caching config / routes / views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting FrankenPHP..."
exec frankenphp run --config /etc/caddy/Caddyfile
