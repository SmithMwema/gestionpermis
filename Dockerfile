FROM php:8.2-fpm

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    git \
    curl \git add Dockerfile
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation de Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Installation des dépendances Node et compilation des assets
RUN npm install && npm run build

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exposer le port
EXPOSE 8000

# Démarrer l'application
CMD php artisan serve --host=0.0.0.0 --port=8000