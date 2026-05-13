#!/usr/bin/env php
<?php

echo "========================================\n";
echo "Checking if database needs seeding...\n";
echo "========================================\n\n";

// Change to Laravel root directory
chdir(dirname(__DIR__));

// Run artisan command to check if admin exists and seed if needed
passthru('php artisan tinker <<\'EOF\'
use App\Models\User;
if (!User::where("role", "admin")->exists()) {
  echo "Seeding database...\\n";
  Artisan::call("db:seed", ["--force" => true]);
  echo "✓ Database seeded!\\n";
} else {
  echo "✓ Admin already exists - skipping seed\\n";
}
exit;
EOF
');

