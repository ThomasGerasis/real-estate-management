# Base image with Apache + PHP-FPM
FROM apache-php83-fpm2

# Set working directory
WORKDIR /app

USER www-data

# ownership of the app directory
RUN chown -R www-data:www-data /app