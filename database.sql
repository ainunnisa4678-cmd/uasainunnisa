-- ============================================================
--  DATABASE: data_menu_restoran
--  Proyek  : UAS Data Menu Restoran
--  NIM     : 251011701031
--  Tanggal : 2026-07-01
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";



-- ============================================================
--  TABEL 1: users
--  Menyimpan data akun pengguna sistem
-- ============================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `username`     VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nama Mahasiswa sebagai username',
  `password`     VARCHAR(255) NOT NULL COMMENT 'Password di-hash dengan password_hash()',
  `role`         ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `nama_lengkap` VARCHAR(150) NULL,
  `nim`          VARCHAR(50)  NULL,
  `email`        VARCHAR(150) NULL,
  `status`       ENUM('Aktif', 'Tidak_aktif') NOT NULL DEFAULT 'Aktif',
  `tgl_daftar`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_active`  TIMESTAMP NULL DEFAULT NULL,
  `foto`         VARCHAR(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  TABEL 2: menu_restoran
--  Menyimpan seluruh data menu yang dikelola
-- ============================================================
DROP TABLE IF EXISTS `menu_restoran`;
CREATE TABLE `menu_restoran` (
  `id_menu`   INT(11)          NOT NULL AUTO_INCREMENT,
  `nama_menu` VARCHAR(150)     NOT NULL,
  `kategori`  VARCHAR(100)     NOT NULL,
  `harga`     DECIMAL(12, 0)   NOT NULL DEFAULT 0,
  `stok`      INT(11)          NOT NULL DEFAULT 0,
  `deskripsi` TEXT                      DEFAULT NULL,
  `image`     VARCHAR(255)              DEFAULT NULL,
  `status`    ENUM('Tersedia','Habis')  NOT NULL DEFAULT 'Tersedia',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  RELASI SEDERHANA
--  Tabel menu_restoran tidak memiliki foreign key ke users
--  karena data menu bersifat global (dikelola semua user).
--  Relasi diterapkan pada level aplikasi (session login).
-- ============================================================

-- ============================================================
--  DATA AWAL: users
--  Username : admin (Nama Mahasiswa)
--  Password : password  →  di-hash dengan password_hash()
-- ============================================================
INSERT INTO `users` (`username`, `password`, `role`, `nama_lengkap`, `nim`, `email`, `status`, `tgl_daftar`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Samso Supriyatna', '2021001', 'sams@gmail.com', 'Aktif', '2024-01-15 08:00:00'),
('ikhsan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'Muhammad Ikhsan', '2021002', 'm.ikhsan@gmail.com', 'Aktif', '2024-02-20 09:30:00'),
('fitri', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'Fitri Fujiyanti', '2021003', 'Fitri.fuji@gmail.com', 'Tidak_aktif', '2024-03-10 14:15:00');

-- ============================================================
--  DATA AWAL: menu_restoran
--  id_menu baris pertama = 1031001 (4 digit akhir NIM)
--  Berikutnya AUTO_INCREMENT: 1031002, 1031003, dst.
-- ============================================================
ALTER TABLE `menu_restoran` AUTO_INCREMENT = 1031001;

INSERT INTO `menu_restoran` (`nama_menu`, `kategori`, `harga`, `stok`, `deskripsi`, `image`, `status`) VALUES
('Nasi Goreng Spesial',  'Makanan', 25000,  20,
 'Nasi goreng dengan bumbu rempah pilihan, dilengkapi telur mata sapi dan ayam suwir.', NULL,
 'Tersedia'),

('Ayam Bakar Madu',      'Makanan', 30000,  15,
 'Ayam bakar dengan olesan madu manis gurih, disajikan bersama sambal terasi dan lalapan segar.', NULL,
 'Tersedia'),

('Es Teh Manis',         'Minuman',  5000,  50,
 'Teh melati segar dengan gula asli, disajikan dingin dengan es batu.', NULL,
 'Tersedia'),

('Kopi Susu Gula Aren',  'Minuman', 15000,   0,
 'Kopi robusta pilihan dicampur susu segar dan gula aren murni dari petani lokal.', NULL,
 'Habis'),

('Pisang Goreng Keju',   'Cemilan', 12000,  30,
 'Pisang kepok goreng crispy dengan taburan keju parut dan susu kental manis.', NULL,
 'Tersedia');
