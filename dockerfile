# ==================== STEVEN ACADEMY - Dockerfile (PHP + Apache) ====================

FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite (importante para rutas limpias)
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . /var/www/html/

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer puerto de Apache
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]