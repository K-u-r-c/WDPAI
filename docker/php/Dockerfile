FROM php:8.2.11-fpm-alpine3.18

# Install PostgreSQL PDO extension
RUN apk --no-cache add postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

# Copy the application code
COPY . /app

VOLUME ["/app"]