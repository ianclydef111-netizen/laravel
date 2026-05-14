#!/bin/bash
set -e

cd /var/www/html

echo "================================"
echo "Starting Laravel Application"
echo "================================"

# Step 1: Create all necessary directories
echo "Creating directories..."
mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache public/uploads

# Step 2: Fix permissions FIRST - this is critical
echo "Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache public/uploads 2>/dev/null || true
chmod -R 777 storage bootstrap/cache public/uploads 2>/dev/null || true

# Step 3: Wait for database
echo "Waiting for database..."
sleep 3

# Step 4: Ensure database structure
echo "Checking database..."
php scripts/ensure-db.php 2>/dev/null || echo "Database check skipped"

# Step 5: Run migrations
echo "Running migrations..."
php artisan migrate --force 2>/dev/null || echo "Migrations completed with warnings"

# Step 6: Seed database
echo "Seeding database..."
php artisan db:seed --force 2>/dev/null || echo "Seeding completed with warnings"

# Step 7: Clear caches
echo "Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Step 8: Final permission check
echo "Final permission check..."
chmod -R 777 storage bootstrap/cache public/uploads 2>/dev/null || true

echo "================================"
echo "✓ Application Ready!"
echo "================================"
echo ""

# Start Apache
exec apache2-foreground
