FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo_pgsql zip

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Debug: Show what's in the directory
RUN ls -la

# Debug: Show composer.json
RUN cat composer.json

# Debug: Run composer with full verbosity
RUN composer install --verbose --no-interaction --optimize-autoloader --no-dev 2>&1

RUN chown -R www-data:www-data storage bootstrap/cache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]