-- ============================================================
-- File    : setup.sql
-- Topik   : Database Sistem Perpustakaan
-- Folder  : php/03-perpustakaan/
-- Author  : Muhammad Alfarezzi Fallevi (50421905)
-- ============================================================
-- Jalankan: mysql -u root -p < setup.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS perpustakaan
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE perpustakaan;

-- Tabel Buku
CREATE TABLE IF NOT EXISTS buku (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    judul        VARCHAR(200)  NOT NULL,
    pengarang    VARCHAR(100)  NOT NULL,
    penerbit     VARCHAR(100),
    tahun_terbit YEAR,
    isbn         VARCHAR(20)   UNIQUE,
    stok         INT           DEFAULT 0,
    kategori     VARCHAR(50),
    created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Anggota
CREATE TABLE IF NOT EXISTS anggota (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nama         VARCHAR(100)  NOT NULL,
    no_anggota   VARCHAR(20)   NOT NULL UNIQUE,
    email        VARCHAR(100),
    telepon      VARCHAR(15),
    alamat       TEXT,
    aktif        TINYINT(1)    DEFAULT 1,
    created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Peminjaman
CREATE TABLE IF NOT EXISTS peminjaman (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    id_anggota      INT           NOT NULL,
    id_buku         INT           NOT NULL,
    tgl_pinjam      DATE          NOT NULL,
    tgl_kembali     DATE          NOT NULL,  -- batas kembali
    tgl_dikembalikan DATE          NULL,      -- tanggal aktual kembali
    status          ENUM('dipinjam','dikembalikan','terlambat') DEFAULT 'dipinjam',
    denda           INT           DEFAULT 0,  -- denda dalam rupiah
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id) ON DELETE RESTRICT,
    FOREIGN KEY (id_buku)    REFERENCES buku(id)    ON DELETE RESTRICT
);

-- Seed data Buku
INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, stok, kategori) VALUES
    ('Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, '978-0132350884', 3, 'Pemrograman'),
    ('The Pragmatic Programmer', 'David Thomas', 'Addison-Wesley', 2019, '978-0135957059', 2, 'Pemrograman'),
    ('Belajar SQL dari Nol', 'Andi Wijaya', 'Elex Media', 2022, '978-0000000001', 5, 'Database'),
    ('Laravel untuk Pemula', 'Budi Santoso', 'Informatika', 2023, '978-0000000002', 4, 'Web Development'),
    ('Algoritma dan Struktur Data', 'Rinaldi Munir', 'Informatika', 2021, '978-0000000003', 3, 'Ilmu Komputer'),
    ('Sistem Basis Data', 'Hendra Gunawan', 'Elex Media', 2020, '978-0000000004', 2, 'Database'),
    ('JavaScript Modern', 'Citra Dewi', 'Gramedia', 2023, '978-0000000005', 4, 'Web Development'),
    ('Python untuk Data Science', 'Eko Prasetyo', 'Elex Media', 2022, '978-0000000006', 3, 'Data Science');

-- Seed data Anggota
INSERT INTO anggota (nama, no_anggota, email, telepon, alamat) VALUES
    ('Levi Alfarezzi',  'A001', 'levi@email.com',  '08111', 'Jakarta'),
    ('Andi Santoso',    'A002', 'andi@email.com',  '08222', 'Bandung'),
    ('Sari Indah',      'A003', 'sari@email.com',  '08333', 'Surabaya'),
    ('Budi Prasetyo',   'A004', 'budi@email.com',  '08444', 'Yogyakarta'),
    ('Dewi Rahayu',     'A005', 'dewi@email.com',  '08555', 'Medan');

-- Seed data Peminjaman
INSERT INTO peminjaman (id_anggota, id_buku, tgl_pinjam, tgl_kembali, status) VALUES
    (1, 1, '2025-06-01', '2025-06-15', 'dipinjam'),
    (2, 3, '2025-06-05', '2025-06-19', 'dipinjam'),
    (3, 2, '2025-05-20', '2025-06-03', 'dikembalikan'),
    (1, 4, '2025-06-10', '2025-06-24', 'dipinjam');

-- Update stok setelah peminjaman aktif
UPDATE buku SET stok = stok - 1 WHERE id IN (1, 3, 4);