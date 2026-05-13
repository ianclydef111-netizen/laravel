#!/bin/bash

echo "Starting Laravel Application..."

# Give database a moment to be ready
sleep 5

# Run PHP script to ensure database tables exist
echo "Ensuring critical database tables exist..."
php /var/www/html/scripts/ensure-db.php || true

# Run migrations with detailed output
echo "Running database migrations..."
php artisan migrate --force || true

# Clear caches
echo "Clearing caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

echo "Starting Apache..."
apache2-foreground
