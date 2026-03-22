# 02 — PHP + MySQL (PDO)

**Topik:** Koneksi Database, PDO, CRUD, Transaksi  
**File:** `config.php` + `setup.sql` + `index.php`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🚀 Cara Jalankan

```bash
# 1. Import database dulu
mysql -u root -p < setup.sql

# 2. Sesuaikan config.php jika perlu (host, user, password)

# 3. Jalankan PHP server
php -S localhost:8000

# 4. Buka browser
# http://localhost:8000
```

---

## 🧠 PDO vs MySQLi

| | PDO | MySQLi |
|---|---|---|
| Database support | MySQL, PostgreSQL, SQLite, dll | MySQL saja |
| API | OOP | OOP + prosedural |
| Prepared statement | ✅ Named & positional | ✅ Positional saja |
| Rekomendasi | ✅ Untuk project baru | Untuk project MySQL-only |

**Gunakan PDO** — lebih fleksibel, bisa pindah database tanpa ubah banyak kode.

---

## 📖 Konsep Penting

### Koneksi PDO
```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=belajar_php;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lempar exception jika error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // hasil sebagai array
        PDO::ATTR_EMULATE_PREPARES   => false,                  // prepared statement asli
    ]
);
```

### Prepared Statement — WAJIB Jika Ada Input User
```php
// ❌ BAHAYA — rentan SQL Injection
$sql = "SELECT * FROM users WHERE npm = '$npm'";

// ✅ AMAN — prepared statement
$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE npm = :npm");
$stmt->execute([':npm' => $npm]);
$data = $stmt->fetch();
```

### CRUD Lengkap
```php
// SELECT
$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE jurusan = :jurusan");
$stmt->execute([':jurusan' => 'Teknik Informatika']);
$rows = $stmt->fetchAll(); // semua baris
$row  = $stmt->fetch();    // satu baris
$val  = $stmt->fetchColumn(); // satu nilai

// INSERT
$stmt = $pdo->prepare("INSERT INTO mahasiswa (nama, npm) VALUES (:nama, :npm)");
$stmt->execute([':nama' => 'Levi', ':npm' => '50421905']);
$id_baru = $pdo->lastInsertId();

// UPDATE
$stmt = $pdo->prepare("UPDATE mahasiswa SET ipk = :ipk WHERE npm = :npm");
$stmt->execute([':ipk' => 3.80, ':npm' => '50421905']);
$affected = $stmt->rowCount(); // berapa baris terpengaruh

// DELETE
$stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE npm = :npm");
$stmt->execute([':npm' => '50421905']);
```

### Transaksi
```php
try {
    $pdo->beginTransaction();

    // Operasi 1
    $stmt->execute([...]);
    // Operasi 2
    $stmt->execute([...]);

    $pdo->commit(); // simpan semua

} catch (Exception $e) {
    $pdo->rollBack(); // batalkan semua
}
```

---

## 🗂️ Isi File

### `config.php`
Konfigurasi koneksi database (host, nama DB, user, password, charset).

### `setup.sql`
Script pembuatan database + tabel + seed data. Jalankan ini dulu sebelum `index.php`.

### `index.php`
8 section pembelajaran lengkap:

| Section | Topik |
|---|---|
| 1 | Koneksi PDO + konfigurasi options |
| 2 | SELECT — `query()`, prepared statement, `fetch()`, `fetchColumn()`, `bindParam` vs `bindValue` |
| 3 | INSERT — `lastInsertId()`, `rowCount()` |
| 4 | UPDATE — verifikasi setelah update |
| 5 | DELETE — soft delete vs hard delete |
| 6 | Transaksi — `beginTransaction()`, `commit()`, `rollBack()` |
| 7 | Fetch mode — `FETCH_ASSOC`, `FETCH_OBJ`, `FETCH_CLASS` |
| 8 | Helper functions — fungsi reusable untuk operasi DB |

---

## ⚠️ SQL Injection

SQL Injection terjadi ketika input user dimasukkan langsung ke query:

```php
// User mengirim: npm = "' OR '1'='1"
$sql = "SELECT * FROM mahasiswa WHERE npm = '$npm'";
// Query jadi: SELECT * FROM mahasiswa WHERE npm = '' OR '1'='1'
// → mengembalikan SEMUA data!
```

**Solusi:** Selalu pakai prepared statement — PDO memisahkan SQL dan data.

---

## ➡️ Selanjutnya

**`03-perpustakaan/`** — Project CRUD lengkap sistem perpustakaan (murni PHP + MySQL)