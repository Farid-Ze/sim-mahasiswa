-- =====================================================================
--  Sistem Informasi Manajemen Data Mahasiswa (SIMADA)
--  Tugas 2 - Penerapan Teknologi Internet (2026/2027 Gasal)
--  Dziban Arkan - 77961325 - IF-3 - Teknik Informatika UNIKOM
-- ---------------------------------------------------------------------
--  Cara pakai: impor file ini lewat phpMyAdmin (tab Import) atau:
--      mysql -u root -p < database/db_kampus.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS db_kampus
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE db_kampus;

-- ---------------------------------------------------------------------
-- Tabel users : akun untuk login (password disimpan dalam bentuk hash)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password      VARCHAR(255) NOT NULL,
    nama_lengkap  VARCHAR(100) NOT NULL
);

-- Akun default -> username: admin | password: admin123
-- (hash dibuat dengan password_hash('admin123', PASSWORD_DEFAULT))
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$10$nA4gYBMx5JjOIwwce/sjTeLvPoBtrTLOKufu1Qi/KP4c2LddqwTMu', 'Dziban Arkan');

-- ---------------------------------------------------------------------
-- Tabel mahasiswa : data utama yang dikelola (CRUD)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS mahasiswa;
CREATE TABLE mahasiswa (
    id             INT PRIMARY KEY AUTO_INCREMENT,
    nim            VARCHAR(10)  NOT NULL UNIQUE,
    nama           VARCHAR(100) NOT NULL,
    email          VARCHAR(100) NOT NULL,
    jenis_kelamin  ENUM('L','P') NOT NULL,
    jurusan        VARCHAR(100) NOT NULL,
    angkatan       YEAR         NOT NULL,
    alamat         TEXT         NULL,
    created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa (nim, nama, email, jenis_kelamin, jurusan, angkatan, alamat) VALUES
('77961325', 'Dziban Arkan',   'dziban.arkan@mahasiswa.unikom.ac.id', 'L', 'Teknik Informatika', 2024, 'Jl. Dipati Ukur No. 112, Bandung'),
('10123001', 'Budi Santoso',   'budi@email.com',  'L', 'Teknik Informatika', 2023, 'Jl. Dago No. 10, Bandung'),
('10123002', 'Sari Dewi',      'sari@email.com',  'P', 'Sistem Informasi',   2023, 'Jl. Riau No. 5, Bandung'),
('10123003', 'Andi Pratama',   'andi@email.com',  'L', 'Teknik Komputer',    2023, 'Jl. Cihampelas No. 21, Bandung'),
('10124004', 'Rina Marlina',   'rina@email.com',  'P', 'Desain Komunikasi Visual', 2024, 'Jl. Setiabudi No. 77, Bandung'),
('10124005', 'Yaris Riyadi',   'yaris@email.com', 'L', 'Teknik Informatika', 2024, 'Jl. Sukajadi No. 8, Bandung');
