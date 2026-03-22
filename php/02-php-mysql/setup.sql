-- ============================================================
-- File    : setup.sql
-- Topik   : Setup Database untuk Latihan PHP + MySQL
-- Folder  : php/02-php-mysql/
-- Author  : Muhammad Alfarezzi Fallevi (50421905)
-- ============================================================
-- Jalankan file ini dulu sebelum menjalankan file PHP:
--   mysql -u root -p < setup.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS belajar_php
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE belajar_php;

-- Tabel mahasiswa untuk latihan CRUD
CREATE TABLE IF NOT EXISTS mahasiswa (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    npm         VARCHAR(15)  NOT NULL UNIQUE,
    email       VARCHAR(100),
    jurusan     VARCHAR(100),
    ipk         DECIMAL(3,2) DEFAULT 0.00,
    aktif       TINYINT(1)   DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk latihan transaksi
CREATE TABLE IF NOT EXISTS rekening (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    saldo       DECIMAL(15,2) DEFAULT 0.00,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed data
INSERT INTO mahasiswa (nama, npm, email, jurusan, ipk) VALUES
    ('Levi Alfarezzi',  '50421905', 'levi@email.com',  'Teknik Informatika', 3.75),
    ('Andi Santoso',    '50421906', 'andi@email.com',  'Teknik Informatika', 3.20),
    ('Sari Indah',      '50421907', 'sari@email.com',  'Sistem Informasi',   3.50),
    ('Budi Prasetyo',   '50421908', 'budi@email.com',  'Teknik Informatika', 2.95),
    ('Dewi Rahayu',     '50421909', 'dewi@email.com',  'Sistem Informasi',   3.80),
    ('Eko Wahyudi',     '50421910', 'eko@email.com',   'Teknik Informatika', 3.10),
    ('Fitri Lestari',   '50421911', 'fitri@email.com', 'Sistem Informasi',   3.65);

INSERT INTO rekening (nama, saldo) VALUES
    ('Levi',  5000000),
    ('Andi',  3000000);