#!/usr/bin/env php
<?php

echo "========================================\n";
echo "Checking if database needs seeding...\n";
echo "========================================\n\n";

try {
    // Bootstrap Laravel
    require __DIR__ . '/../bootstrap/app.php';
    
    $app = require __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // Check if admin user exists
    $adminExists = \App\Models\User::where('role', 'admin')->exists();
    
    if ($adminExists) {
        echo "✓ Admin user already exists - skipping seed\n\n";
        exit(0);
    }
    
    echo "Admin user not found - running database seed...\n\n";
    
    // Run the seeder
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    
    echo "\n✓ Database seeded successfully!\n";
    echo "\nDefault Admin Credentials:\n";
    echo "  Email: admin@pharmacy.com\n";
    echo "  Password: Admin@1234\n\n";
    
} catch (Exception $e) {
    echo "⚠ Warning: Seeding encountered an issue\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "You may need to seed manually with: php artisan db:seed\n\n";
}
