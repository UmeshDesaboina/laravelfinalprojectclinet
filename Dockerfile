FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    oniguruma-dev \
    fcgi \
    mariadb-client \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite zip bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/cache/apk/*

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN npm install && npm run build

RUN chmod -R 755 storage bootstrap/cache

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8080

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]