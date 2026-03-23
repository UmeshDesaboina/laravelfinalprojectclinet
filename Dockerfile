# FROM php:8.2-fpm-alpine

# WORKDIR /var/www/html

# RUN apk add --no-cache \
#     nginx \
#     supervisor \
#     curl \
#     git \
#     unzip \
#     zip \
#     libzip-dev \
#     oniguruma-dev \
#     fcgi \
#     mariadb-client \
#     nodejs \
#     npm

# RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite zip bcmath

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN rm -rf /var/cache/apk/*

# COPY . .

# RUN composer install --optimize-autoloader --no-dev --no-interaction

# RUN npm install && npm run build

# RUN chmod -R 755 storage bootstrap/cache

# RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# EXPOSE 8080

# COPY docker/nginx.conf /etc/nginx/http.d/default.conf
# COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]


# FROM php:8.2-cli

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     git unzip curl libzip-dev zip libpq-dev \
#     && docker-php-ext-install zip pdo pdo_pgsql

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Set working directory
# WORKDIR /var/www

# # Copy project
# COPY . .

# # Install Laravel dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Permissions
# RUN chmod -R 777 storage bootstrap/cache

# # Cache config (optional)
# RUN php artisan config:cache || true

# # Expose port
# EXPOSE 10000

# # Start Laravel
# CMD php artisan serve --host=0.0.0.0 --port=10000

FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

# 🔥 RUN MIGRATION AT START TIME (IMPORTANT)
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
