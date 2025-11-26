<?php

// Seeder to populate users table with initial data
return function($pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email) VALUES
        ('John Doe', 'john@example.com'),
        ('Alice', 'alice@example.com');
    ");
    $stmt->execute();

    echo "Users seeded.\n";
};
