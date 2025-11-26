<?php

// Rollback the last applied migration
require 'db.php';

// Get the last applied migration from the migrations table
$last = $pdo->query("SELECT id,migration FROM migrations ORDER BY id DESC LIMIT 1")->fetch();

if (!$last) {
    die("Nothing to rollback.\n");
}

$file = $last['migration'];

// Load the migration file and execute the down method
$migration = include "migrations/$file";

echo "Rolling back: $file\n";
// Execute the down SQL command
$pdo->exec($migration['down']);

// Remove the migration record from the migrations table
$pdo->prepare("DELETE FROM migrations WHERE id = ?")->execute([$last['id']]);

echo "Rollback complete.\n";
