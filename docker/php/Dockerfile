FROM php:8.2-fpm

# 1. Instalación de dependencias del sistema
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# 2. Traer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- INTEGRACIÓN DE CONFIGURACIÓN PERSONALIZADA ---
# Copiamos tu archivo ini a la carpeta de configuración oficial de PHP
COPY ./docker/php/php-extra.ini /usr/local/etc/php/conf.d/php-extra.ini

# 3. COPIAR DEPENDENCIAS
COPY composer.json composer.lock ./

# 4. Instalar dependencias
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# 5. Copiar el resto del proyecto
COPY . .

# 6. Finalizar configuración de Laravel
RUN composer dump-autoload --optimize
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache