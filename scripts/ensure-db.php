#!/usr/bin/env php
<?php

// Simple table check and creation script
echo "Checking database and creating tables if needed...\n";

try {
    $config = require __DIR__ . '/../config/database.php';
    
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;dbname=%s',
            getenv('DB_HOST'),
            getenv('DB_PORT') ?: 3306,
            getenv('DB_DATABASE')
        ),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✓ Database connected\n";
    
    // Check if sessions table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'sessions'");
    if ($stmt->rowCount() === 0) {
        echo "Creating sessions table...\n";
        $pdo->exec(<<<SQL
        CREATE TABLE `sessions` (
          `id` varchar(255) NOT NULL,
          `user_id` bigint unsigned DEFAULT NULL,
          `ip_address` varchar(45) DEFAULT NULL,
          `user_agent` text DEFAULT NULL,
          `payload` longtext NOT NULL,
          `last_activity` int NOT NULL,
          PRIMARY KEY (`id`),
          KEY `sessions_user_id_index` (`user_id`),
          KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL
        );
        echo "✓ Sessions table created\n";
    } else {
        echo "✓ Sessions table already exists\n";
    }
    
} catch (Exception $e) {
    echo "⚠ Warning: Could not check/create sessions table: " . $e->getMessage() . "\n";
    echo "Continuing anyway - migrations will run next...\n";
}
