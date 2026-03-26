# 03 — Perpustakaan (CRUD PHP + MySQL)

**Topik:** Project CRUD Sistem Perpustakaan — Murni PHP + MySQL  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 📁 Struktur Project

```
03-perpustakaan/
├── config/
│   └── database.php        ← konfigurasi & fungsi getDB()
├── includes/
│   ├── header.php          ← template HTML atas (navbar, flash message)
│   └── footer.php          ← template HTML bawah
├── assets/
│   └── style.css           ← styling semua halaman
├── pages/
│   ├── buku/
│   │   ├── index.php       ← daftar buku (search + pagination)
│   │   ├── tambah.php      ← form tambah buku + validasi
│   │   ├── edit.php        ← form edit buku
│   │   └── hapus.php       ← proses hapus (cek relasi)
│   ├── anggota/
│   │   ├── index.php       ← daftar anggota (search)
│   │   ├── tambah.php      ← form tambah anggota + validasi
│   │   ├── edit.php        ← form edit anggota
│   │   └── hapus.php       ← proses hapus (cek relasi)
│   └── peminjaman/
│       ├── index.php       ← daftar peminjaman (filter status)
│       ├── tambah.php      ← form catat peminjaman (transaksi)
│       └── kembalikan.php  ← proses pengembalian + hitung denda
├── setup.sql               ← buat database + tabel + seed data
└── index.php               ← dashboard statistik
```

---

## 🚀 Cara Jalankan

```bash
# 1. Import database
mysql -u root -p < setup.sql

# 2. Sesuaikan config/database.php

# 3. Jalankan dari folder ini
php -S localhost:8000

# 4. Buka browser
# http://localhost:8000
```

---

## 🗄️ Database

3 tabel utama:

| Tabel | Kolom Penting |
|---|---|
| `buku` | judul, pengarang, isbn (UNIQUE), stok, kategori |
| `anggota` | nama, no_anggota (UNIQUE), email, aktif |
| `peminjaman` | id_anggota (FK), id_buku (FK), tgl_pinjam, tgl_kembali, status, denda |

---

## ✅ Fitur yang Diimplementasikan

### Buku
- Daftar buku dengan **search** (judul/pengarang) dan **filter kategori**
- **Pagination** — 7 buku per halaman
- Tambah buku dengan **validasi** (judul wajib, ISBN unik, tahun valid)
- Edit buku — form pre-filled dengan data lama
- Hapus buku — **cek relasi** (tidak bisa hapus jika sedang dipinjam)

### Anggota
- Daftar anggota dengan search
- Tambah & edit anggota + validasi email
- Hapus anggota — cek peminjaman aktif

### Peminjaman
- Daftar dengan **filter status** (dipinjam/dikembalikan/terlambat)
- Catat peminjaman — pilih anggota + buku (hanya yang stok > 0)
- **Transaksi** saat catat: INSERT peminjaman + UPDATE stok buku
- **Pengembalian** — hitung denda otomatis (Rp 1.000/hari terlambat)
- **Transaksi** saat kembalikan: UPDATE peminjaman + UPDATE stok

### Dashboard
- Statistik: total buku, anggota aktif, sedang dipinjam, terlambat
- Tabel peminjaman aktif terbaru
- Quick links ke tambah buku/anggota/peminjaman

---

## 🧠 Konsep PHP yang Dipraktikkan

| Konsep | Dipakai Di |
|---|---|
| PDO + Prepared Statement | Semua file — cegah SQL Injection |
| Validasi server-side | `tambah.php`, `edit.php` semua entitas |
| Flash message via Session | Sukses/error setelah redirect |
| PRG Pattern (Post/Redirect/Get) | Semua form — cegah double submit |
| Transaksi PDO | `peminjaman/tambah.php`, `kembalikan.php` |
| `htmlspecialchars()` | Semua output — cegah XSS |
| Query dinamis | Search & filter dengan `WHERE 1=1` |
| Pagination | `buku/index.php` |
| Template include | `header.php`, `footer.php` |
| Relasi antar tabel | Cek FK sebelum hapus |

---

## ➡️ Selanjutnya

**`04-laravel-crud/`** — Versi Laravel dari project perpustakaan ini