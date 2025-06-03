FROM dunglas/frankenphp:latest-php8.4

RUN install-php-extensions \
    pdo_mysql \
    mysqli \
    redis \
    zip \
    gd \
    intl \
    opcache \
    pcntl \
    bcmath \
    exif \
    imagick

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

COPY ./docker/frankenphp/Caddyfile /etc/caddy/Caddyfile

# Expose port
EXPOSE 80

# Start FrankenPHP
CMD ["frankenphp", "run"]
