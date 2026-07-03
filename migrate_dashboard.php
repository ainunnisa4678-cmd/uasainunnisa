<?php
require_once 'config/Database.php';

try {
    $db = new Database();
    
    // 1. Add columns to users table
    $columns = [
        "nama_lengkap" => "VARCHAR(150) NULL AFTER role",
        "nim" => "VARCHAR(50) NULL AFTER nama_lengkap",
        "email" => "VARCHAR(150) NULL AFTER nim",
        "status" => "ENUM('Aktif', 'Tidak_aktif') NOT NULL DEFAULT 'Aktif' AFTER email",
        "tgl_daftar" => "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER status",
        "foto" => "VARCHAR(255) NULL AFTER tgl_daftar"
    ];

    foreach ($columns as $col => $definition) {
        try {
            $db->query("ALTER TABLE `users` ADD COLUMN `$col` $definition");
            $db->execute();
            echo "Column '$col' added.<br>\n";
        } catch (Exception $e) {
            echo "Column '$col' might already exist.<br>\n";
        }
    }

    // 2. Update existing admin
    $db->query("UPDATE `users` SET nama_lengkap = 'Samso Supriyatna', nim = '2021001', email = 'sams@gmail.com', tgl_daftar = '2024-01-15 08:00:00' WHERE username = 'admin'");
    $db->execute();
    echo "Admin updated with dummy data.<br>\n";

    // 3. Insert dummy users if they don't exist
    $dummy_users = [
        ['username' => 'ikhsan', 'nama_lengkap' => 'Muhammad Ikhsan', 'nim' => '2021002', 'email' => 'm.ikhsan@gmail.com', 'status' => 'Aktif', 'tgl' => '2024-02-20 09:30:00'],
        ['username' => 'fitri', 'nama_lengkap' => 'Fitri Fujiyanti', 'nim' => '2021003', 'email' => 'Fitri.fuji@gmail.com', 'status' => 'Tidak_aktif', 'tgl' => '2024-03-10 14:15:00']
    ];

    foreach ($dummy_users as $du) {
        $db->query("SELECT id FROM users WHERE username = :username");
        $db->bind(':username', $du['username']);
        $db->single();
        if ($db->rowCount() == 0) {
            $db->query("INSERT INTO `users` (`username`, `password`, `role`, `nama_lengkap`, `nim`, `email`, `status`, `tgl_daftar`) 
                        VALUES (:username, :password, 'user', :nama, :nim, :email, :status, :tgl)");
            $db->bind(':username', $du['username']);
            $db->bind(':password', password_hash('password', PASSWORD_DEFAULT));
            $db->bind(':nama', $du['nama_lengkap']);
            $db->bind(':nim', $du['nim']);
            $db->bind(':email', $du['email']);
            $db->bind(':status', $du['status']);
            $db->bind(':tgl', $du['tgl']);
            $db->execute();
            echo "Inserted dummy user: {$du['username']}.<br>\n";
        }
    }

    echo "<h3>Migration completed successfully. You can safely remove this file.</h3>";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage();
}
