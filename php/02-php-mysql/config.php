<?php
/*
  ╔══════════════════════════════════════════════════════╗
  ║  File   : config.php                                ║
  ║  Topik  : Konfigurasi Koneksi Database              ║
  ║  Folder : php/02-php-mysql/                         ║
  ║  Author : Muhammad Alfarezzi Fallevi (50421905)     ║
  ╚══════════════════════════════════════════════════════╝

  File ini berisi konfigurasi koneksi database.
  Di-require_once dari semua file yang butuh koneksi DB.

  JANGAN commit file ini ke GitHub jika berisi password asli!
  Gunakan .env atau config terpisah yang di-.gitignore
*/

// Konstanta konfigurasi database
define('DB_HOST', 'localhost');
define('DB_NAME', 'belajar_php');
define('DB_USER', 'root');
define('DB_PASS', '');          // kosong untuk XAMPP default
define('DB_CHARSET', 'utf8mb4');

/*
  Kenapa utf8mb4 bukan utf8?
  utf8 di MySQL hanya mendukung 3 byte (tidak bisa emoji)
  utf8mb4 mendukung 4 byte (mendukung semua karakter Unicode termasuk emoji)
  Selalu pakai utf8mb4 untuk project baru!
*/

// DSN — Data Source Name
// Format: dbtype:host=...;dbname=...;charset=...
define('DB_DSN', "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET);