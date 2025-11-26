<?php

// Migrate the database
require 'db.php';

// ensure migrations table exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Scan the migrations directory for migration files and execute them in order
$files = scandir('migrations');
foreach ($files as $file) {
    if (preg_match('/\.php$/', $file)) {

        // check if already migrated
        $stmt = $pdo->prepare("SELECT * FROM migrations WHERE migration=?");
        $stmt->execute([$file]); // bind and execute
        
        if ($stmt->rowCount() > 0) {
            continue; // already migrated
        }

        $migration = include "migrations/$file";
        echo "Running migration: $file\n";
        $pdo->exec($migration['up']); // execute up SQL command

        // store record
        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$file]); // bind and execute
    }
}

echo "Migrations completed.\n";
