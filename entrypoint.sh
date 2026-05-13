#!/bin/bash
set -e

echo "======================================="
echo "Starting Laravel Application Startup"
echo "======================================="

# Wait for database to be ready
echo "Waiting for database connection..."
for i in {1..30}; do
  if php artisan migrate:status > /dev/null 2>&1; then
    echo "Database is ready!"
    break
  fi
  echo "Attempt $i: Waiting for database..."
  sleep 2
done

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Clear application caches
echo "Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Set proper permissions
echo "Setting storage permissions..."
mkdir -p /var/www/html/storage/framework/{cache,sessions,views}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "======================================="
echo "Application Ready! Starting Apache..."
echo "======================================="

exec apache2-foreground
