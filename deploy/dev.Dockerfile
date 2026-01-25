# Base image with Apache + PHP-FPM
FROM apache-php83-fpm2

# Set working directory
WORKDIR /app

USER www-data