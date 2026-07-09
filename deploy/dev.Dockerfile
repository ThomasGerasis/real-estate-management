# Dev image — FrankenPHP + Xdebug (source mounted as volume)
FROM dunglas/frankenphp:php8.3-alpine

RUN apk add --no-cache bash git curl

# Same extensions as prod + xdebug
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

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

EXPOSE 80

# Source is volume-mounted — php artisan serve picks up changes instantly
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]