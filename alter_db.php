<?php
require_once 'config/Config.php';
require_once 'config/Database.php';

$db = new Database();

// Add image column if not exists
try {
    $db->query("ALTER TABLE menu_restoran ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER deskripsi");
    $db->execute();
    echo "Column 'image' added successfully.\n";
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Column 'image' already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Create directory
if (!is_dir('assets/img')) {
    mkdir('assets/img', 0777, true);
    echo "Directory 'assets/img' created.\n";
} else {
    echo "Directory 'assets/img' already exists.\n";
}
