<?php

// Database connection settings
$dsn = 'mysql:host=localhost;dbname=migrations_demo;charset=utf8';
$user = 'root';
$pass = '';

// Create a PDO instance
try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
