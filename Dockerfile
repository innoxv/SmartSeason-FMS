FROM node:20-slim AS node

WORKDIR /app
COPY package*.json ./
RUN npm ci

FROM php:8.4-apache

# Install npm in the PHP container
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev zip unzip git \
    npm \
    && docker-php-ext-install pdo_pgsql zip

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

# Copy node_modules and run build (npm is now available)
COPY --from=node /app/node_modules /var/www/html/node_modules
RUN npm run build

# Create manifest symlink for Vite
RUN if [ -f public/build/.vite/manifest.json ]; then cp public/build/.vite/manifest.json public/build/manifest.json; fi

RUN chown -R www-data:www-data storage bootstrap/cache public/build
RUN chmod -R 775 storage bootstrap/cache public/build

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]