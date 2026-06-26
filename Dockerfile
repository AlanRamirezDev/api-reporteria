FROM php:8.3-apache

# Dependencias del sistema y extensiones de PHP básicas
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip

# Habilitar mod_rewrite para el enrutamiento de Laravel
RUN a2enmod rewrite

# Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias de producción de Laravel
RUN composer install --optimize-autoloader --no-dev

# Configurar permisos para los directorios de almacenamiento y caché requeridos por Blade
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Redireccionar la raíz de Apache hacia la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT="/var/www/html/public"
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Exponer el puerto estándar de HTTP
EXPOSE 80