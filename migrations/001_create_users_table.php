<?php

// Migration to create users table 
return [
    "up" => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    "down" => "
        DROP TABLE IF EXISTS users;
    "
];
