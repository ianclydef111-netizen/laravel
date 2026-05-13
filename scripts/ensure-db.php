#!/usr/bin/env php
<?php

echo "Waiting for database...\n";

$maxAttempts = 30;
$attempt = 0;

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
            getenv('DB_PASSWORD')
        );
        
        echo "✓ Database connected\n";
        
        // Create sessions table if missing
        try {
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
                );
                echo "✓ Sessions table created\n";
            }
        } catch (Exception $e) {
            // Ignore errors - migrations will handle it
        }
        
        exit(0);
        
    } catch (PDOException $e) {
        $attempt++;
        if ($attempt >= $maxAttempts) {
            echo "Could not connect after $maxAttempts attempts\n";
            exit(0); // Continue anyway
        }
        echo "Attempt $attempt/$maxAttempts...\n";
        sleep(2);
    }
}

