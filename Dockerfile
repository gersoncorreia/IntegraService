# =============================================================================
# ESTÁGIO 1: Build dos Assets Frontend (Vue.js 3.5 + Tailwind CSS 4 + Vite)
# =============================================================================
FROM node:22-alpine AS frontend-builder

WORKDIR /app

COPY package.json package-lock.json* .npmrc* ./
RUN npm ci || npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build

# =============================================================================
# ESTÁGIO 2: Servidor PHP 8.4 FPM + Extensões Laravel + Composer
# =============================================================================
FROM php:8.4-fpm-alpine

# Instalar dependências de sistema e extensões PHP necessárias para Laravel + MySQL
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    libzip-dev \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
        opcache

# Instalar Composer oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . /var/www/html

# Copiar assets compilados do Estágio 1 (garante build sempre atualizado)
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# Instalar pacotes PHP de produção otimizados
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ajustar permissões das pastas storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
