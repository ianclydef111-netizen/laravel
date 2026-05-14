FROM php:8.3-apache

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
git \
unzip \
curl \
libpq-dev \
libzip-dev \
libonig-dev \
libxml2-dev \
libpng-dev \
libgd-dev \
zip \
&& docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml gd \
&& apt-get clean \
&& rm -rf /var/lib/apt/lists/*
# Enable Apache rewrite
RUN a2enmod rewrite
# Make Apache use port 10000 (Render default)
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
&& sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf
# Set Laravel public as document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
&& sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf
# Allow .htaccess for Laravel
RUN printf '<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
&& a2enconf laravel
# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
&& apt-get install -y nodejs
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# Set working directory
WORKDIR /var/www/html
# Copy Laravel app
COPY . .
# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy helper scripts
COPY scripts/ /var/www/html/scripts/
RUN chmod +x /var/www/html/scripts/*.php || true

# Install frontend dependencies and build assets
RUN npm install && npm run build 2>&1 || echo "Warning: npm build had issues but continuing..."

# Clear config cache (no migrations during build)
RUN php artisan config:clear || true
RUN php artisan view:clear || true

# Create storage symlink
RUN php artisan storage:link || true

# Fix permissions - create directories and set ownership
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
&& mkdir -p /var/www/html/storage/logs \
&& mkdir -p /var/www/html/bootstrap/cache \
&& mkdir -p /var/www/html/public/uploads \
&& chown -R www-data:www-data /var/www/html \
&& chmod -R 775 /var/www/html/storage \
&& chmod -R 775 /var/www/html/bootstrap/cache \
&& chmod -R 755 /var/www/html/public

# Expose port
EXPOSE 10000

# Use CMD to call the entrypoint script
CMD ["/bin/bash", "/usr/local/bin/entrypoint.sh"]