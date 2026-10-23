# ==========================================
# Optimized Dockerfile for Laravel + Vite
# Compatible with Render Free Tier (512MB RAM)
# ==========================================

# Stage 1: Build frontend assets
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Application Environment
FROM php:8.3-cli-alpine

# Install minimal runtime packages (lightweight, zero memory issues)
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    sqlite-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev

# Install only essential PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    bcmath \
    opcache

# Get Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_KEY=base64:zYY3NMaAikWGc/cMPluNRAPgbzTKvd6K5S4kbQY/MIA=
ENV DB_CONNECTION=sqlite
ENV SESSION_DRIVER=database
ENV CACHE_STORE=database
ENV QUEUE_CONNECTION=database
ENV ADMIN_NAME="Administrador Sytro"
ENV ADMIN_EMAIL="obandowilmer59@gmail.com"
ENV ADMIN_INITIAL_PASSWORD="78chocolate"
ENV PORT=10000

# Copy application and pre-built frontend
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies without dev dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Prepare directories and sqlite database
RUN mkdir -p database storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database \
    && php artisan storage:link --force || true

EXPOSE 10000

# Start command
CMD sh -c "php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
