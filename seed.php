<?php

// Seed the database with initial data
require 'db.php';

// Scan the seeders directory for seeder files and execute them in order
$files = scandir('seeders');

// Exclude . and 
foreach ($files as $file) {
    if (preg_match('/\.php$/', $file)) {
        echo "Running seeder: $file\n";
        $seeder = include "seeders/$file";
        $seeder($pdo); // execute closure
    }
}

echo "Seeding completed.\n";
