<?php
require_once 'config/Database.php';

try {
    $db = new Database();
    
    // Add role column if it doesn't exist
    try {
        $db->query("ALTER TABLE `users` ADD COLUMN `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user' AFTER `password`");
        $db->execute();
        echo "Column 'role' added.\n";
    } catch (Exception $e) {
        echo "Column 'role' might already exist: " . $e->getMessage() . "\n";
    }

    // Update admin user
    $db->query("UPDATE `users` SET `role` = 'admin' WHERE `username` = 'admin'");
    $db->execute();
    echo "Admin role updated.\n";
    
    // Also update database.sql to reflect this change
    
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage();
}
