#!/usr/bin/env php
<?php

echo "========================================\n";
echo "Database Initialization Script\n";
echo "========================================\n\n";

$maxAttempts = 30;
$attempt = 0;
$pdo = null;

// Try to connect to database
while ($attempt < $maxAttempts) {
    try {
        $pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST') ?: 'localhost',
                getenv('DB_PORT') ?: 3306,
                getenv('DB_DATABASE')
            ),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        echo "✓ Database connected successfully!\n\n";
        break;
        
    } catch (PDOException $e) {
        $attempt++;
        if ($attempt >= $maxAttempts) {
            echo "✗ Could not connect to database after $maxAttempts attempts\n";
            echo "Error: " . $e->getMessage() . "\n";
            echo "This is OK - migrations will try to run anyway\n\n";
            exit(0);
        }
        echo "Attempt $attempt/$maxAttempts - Waiting for database...\n";
        sleep(2);
    }
}

if (!$pdo) {
    echo "⚠ Database connection failed, continuing anyway...\n\n";
    exit(0);
}

// Create sessions table if it doesn't exist
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'sessions'");
    if ($stmt->rowCount() === 0) {
        echo "Creating 'sessions' table...\n";
        
        $pdo->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS `sessions` (
          `id` varchar(255) NOT NULL,
          `user_id` bigint unsigned DEFAULT NULL,
          `ip_address` varchar(45) DEFAULT NULL,
          `user_agent` text DEFAULT NULL,
          `payload` longtext NOT NULL,
          `last_activity` int NOT NULL,
          PRIMARY KEY (`id`),
          KEY `sessions_user_id_index` (`user_id`),
          KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
        );
        
        echo "✓ Sessions table created\n\n";
    } else {
        echo "✓ Sessions table already exists\n\n";
    }
} catch (PDOException $e) {
    echo "⚠ Could not create sessions table: " . $e->getMessage() . "\n";
    echo "This is OK - Laravel migrations will handle it\n\n";
}

echo "========================================\n";
echo "Proceeding to run migrations...\n";
echo "========================================\n\n";

