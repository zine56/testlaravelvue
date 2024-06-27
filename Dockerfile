# Usar una imagen oficial de PHP como imagen base
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    supervisor

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

COPY --chown=www-data:www-data ./laravel-app .

# Copiar snippets de nginx
COPY ./docker/nginx/snippets /etc/nginx/snippets

# Dar permisos al servidor web para escribir en storage y cache
RUN chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/public

# Permitir que Composer se ejecute como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias de PHP, incluyendo laravel/ui
RUN composer require laravel/ui

# Instalar dependencias de PHP
RUN composer update

# Crear carpetas .npm y .npmrc y cambiar permisos
RUN mkdir /var/www/.npm && chown -R www-data:www-data /var/www/.npm \
    && touch /var/www/.npmrc && chown www-data:www-data /var/www/.npmrc

# Cambiar a un usuario que tenga permisos adecuados antes de ejecutar npm install
USER www-data

# Configurar npm cache dir y instalar dependencias de Node.js
RUN npm config set cache /var/www/.npm && npm install --legacy-peer-deps

# Compilar activos
RUN npm run prod

# Volver al usuario root para las siguientes configuraciones
USER root

# Copiar la configuración de supervisord
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exponer el puerto 9000 y arrancar supervisord
EXPOSE 9000
CMD ["/usr/bin/supervisord"]
