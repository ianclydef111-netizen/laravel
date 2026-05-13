#!/bin/bash

echo "======================================="
echo "Starting Laravel Application Startup"
echo "======================================="

# Wait for database to be ready (max 120 seconds)
echo "Waiting for database connection..."
MAX_ATTEMPTS=60
ATTEMPT=0

while [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
  if php -r "
    \$host = getenv('DB_HOST');
    \$port = getenv('DB_PORT') ?: 3306;
    \$timeout = 3;
    \$connection = @fsockopen(\$host, \$port, \$errno, \$errstr, \$timeout);
    if (\$connection) {
      fclose(\$connection);
      exit(0);
    }
    exit(1);
  " 2>/dev/null; then
    echo "✓ Database is ready!"
    break
  fi
  ATTEMPT=$((ATTEMPT + 1))
  echo "Attempt $ATTEMPT/$MAX_ATTEMPTS: Waiting for database..."
  sleep 2
done

if [ $ATTEMPT -eq $MAX_ATTEMPTS ]; then
  echo "⚠ Warning: Database connection timeout, continuing anyway..."
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "⚠ Migration had issues, continuing..."

# Clear application caches
echo "Clearing application caches..."
php artisan config:clear 2>&1 || true
php artisan route:clear 2>&1 || true
php artisan view:clear 2>&1 || true
php artisan cache:clear 2>&1 || true

# Set proper permissions
echo "Setting storage permissions..."
mkdir -p /var/www/html/storage/framework/{cache,sessions,views}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>&1 || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>&1 || true

echo "======================================="
echo "✓ Application Ready! Starting Apache..."
echo "======================================="

exec apache2-foreground
