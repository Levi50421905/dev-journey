<?php
/*
  ╔══════════════════════════════════════════════════════╗
  ║  File   : index.php                                 ║
  ║  Topik  : PHP + MySQL — Koneksi, PDO, CRUD          ║
  ║  Folder : php/02-php-mysql/                         ║
  ║  Author : Muhammad Alfarezzi Fallevi (50421905)     ║
  ╚══════════════════════════════════════════════════════╝

  Cara jalankan:
  1. Import setup.sql ke MySQL dulu
  2. Sesuaikan config.php (host, user, password)
  3. php -S localhost:8000 (dari folder ini)
  4. Buka http://localhost:8000
*/

require_once 'config.php';

// ============================================================
// SECTION 1: KONEKSI DATABASE
// ============================================================

echo "<h1>02 — PHP + MySQL</h1>";
echo "<h2>1. Koneksi Database</h2>";

/*
  Ada 3 cara koneksi MySQL di PHP:
  1. mysql_*    → DEPRECATED, jangan pakai (sudah dihapus PHP 7)
  2. mysqli_*   → MySQLi (MySQL Improved), prosedural & OOP
  3. PDO        → PHP Data Objects, mendukung banyak database

  GUNAKAN PDO karena:
  - Database agnostic (bisa pindah ke PostgreSQL, SQLite tanpa ubah banyak kode)
  - Mendukung prepared statement dengan cara yang konsisten
  - OOP yang bersih
*/

// --- Koneksi dengan PDO ---
try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        /*
          ERRMODE_EXCEPTION → lempar Exception jika ada error SQL
          Tanpa ini, error SQL diam-diam (silent fail) — susah debug!
        */
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        /*
          FETCH_ASSOC → hasil query sebagai associative array
          ["nama" => "Levi", "npm" => "50421905"]
          Lebih mudah dipakai daripada FETCH_NUM (index numerik)
        */
        PDO::ATTR_EMULATE_PREPARES   => false,
        /*
          false → gunakan prepared statement asli dari MySQL
          true  → PDO emulasi (kurang aman)
          Selalu false untuk keamanan!
        */
    ]);

    echo "<p style='color:green'>✅ Koneksi database berhasil!</p>";

} catch (PDOException $e) {
    // Jangan tampilkan error detail ke user di production!
    // Gunakan logging
    die("<p style='color:red'>❌ Koneksi gagal: " . $e->getMessage() . "</p>");
    /*
      die() → hentikan eksekusi script
      Pakai ini jika koneksi gagal — tidak ada gunanya lanjut
    */
}


// ============================================================
// SECTION 2: SELECT — MEMBACA DATA
// ============================================================

echo "<h2>2. SELECT — Membaca Data</h2>";

// --- 2.1 Query Sederhana (tanpa parameter) ---
echo "<h3>2.1 query() — Tanpa Parameter</h3>";
/*
  query() dipakai untuk SQL yang TIDAK menerima input dari user.
  Jangan pakai query() jika ada variabel dari user — rentan SQL Injection!
*/

$stmt = $pdo->query("SELECT * FROM mahasiswa ORDER BY nama ASC");
$semua_mahasiswa = $stmt->fetchAll();
/*
  fetchAll() → ambil semua baris sebagai array of arrays
  fetch()    → ambil satu baris
*/

echo "<p>Total mahasiswa: " . count($semua_mahasiswa) . "</p>";

// Tampilkan sebagai tabel
echo "<table border='1' cellpadding='8' style='border-collapse:collapse; margin:1rem 0;'>";
echo "<tr><th>ID</th><th>Nama</th><th>NPM</th><th>Jurusan</th><th>IPK</th></tr>";
foreach ($semua_mahasiswa as $mhs) {
    echo "<tr>";
    echo "<td>{$mhs['id']}</td>";
    echo "<td>{$mhs['nama']}</td>";
    echo "<td>{$mhs['npm']}</td>";
    echo "<td>{$mhs['jurusan']}</td>";
    echo "<td>{$mhs['ipk']}</td>";
    echo "</tr>";
}
echo "</table>";

// --- 2.2 Prepared Statement dengan Parameter ---
echo "<h3>2.2 Prepared Statement — Dengan Parameter</h3>";
/*
  SELALU gunakan prepared statement jika ada variabel dari user.

  SQL Injection: user mengirim input berbahaya seperti:
  npm = "50421905' OR '1'='1"
  Query tanpa prepared: SELECT * FROM mahasiswa WHERE npm = '50421905' OR '1'='1'
  → mengembalikan SEMUA data!

  Prepared statement memisahkan SQL dan data — aman dari injection.

  Dua cara binding parameter:
  1. Positional placeholder: ?
  2. Named placeholder: :nama_param (lebih mudah dibaca)
*/

// Named placeholder
$jurusan_cari = "Teknik Informatika";

$stmt = $pdo->prepare("
    SELECT id, nama, npm, ipk
    FROM mahasiswa
    WHERE jurusan = :jurusan
    ORDER BY ipk DESC
");
$stmt->execute([':jurusan' => $jurusan_cari]);
/*
  prepare() → siapkan query
  execute()  → kirim parameter dan jalankan
*/

$hasil = $stmt->fetchAll();

echo "<p>Mahasiswa jurusan <strong>$jurusan_cari</strong>:</p>";
echo "<ul>";
foreach ($hasil as $row) {
    echo "<li>{$row['nama']} ({$row['npm']}) — IPK: {$row['ipk']}</li>";
}
echo "</ul>";

// Positional placeholder
$stmt2 = $pdo->prepare("SELECT * FROM mahasiswa WHERE ipk >= ? AND aktif = ?");
$stmt2->execute([3.5, 1]);
$cumlaude = $stmt2->fetchAll();

echo "<p>Mahasiswa IPK ≥ 3.5 (" . count($cumlaude) . " orang):</p>";
echo "<ul>";
foreach ($cumlaude as $row) {
    echo "<li>{$row['nama']} — IPK: {$row['ipk']}</li>";
}
echo "</ul>";

// --- 2.3 Fetch Satu Baris ---
echo "<h3>2.3 fetch() — Ambil Satu Baris</h3>";

$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE npm = :npm");
$stmt->execute([':npm' => '50421905']);
$satu = $stmt->fetch(); // fetch() → satu baris saja

if ($satu) {
    echo "<p>Ditemukan: <strong>{$satu['nama']}</strong> | IPK: {$satu['ipk']}</p>";
} else {
    echo "<p>Tidak ditemukan.</p>";
}

// --- 2.4 fetchColumn() — Ambil Satu Nilai ---
echo "<h3>2.4 fetchColumn() — Ambil Satu Nilai</h3>";

$stmt = $pdo->query("SELECT COUNT(*) FROM mahasiswa WHERE aktif = 1");
$total = $stmt->fetchColumn();
echo "<p>Total mahasiswa aktif: <strong>$total</strong></p>";

$stmt = $pdo->query("SELECT AVG(ipk) FROM mahasiswa");
$rata_ipk = round($stmt->fetchColumn(), 2);
echo "<p>Rata-rata IPK: <strong>$rata_ipk</strong></p>";

// --- 2.5 bindParam vs bindValue ---
echo "<h3>2.5 bindParam vs bindValue</h3>";

$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE ipk BETWEEN :min AND :max");

$min = 3.0;
$max = 3.5;

/*
  bindParam → bind variabel (by reference) — nilai diambil saat execute()
  bindValue → bind nilai langsung — nilai diambil saat bind

  bindParam lebih berguna dalam loop karena nilai bisa berubah.
  bindValue lebih sederhana untuk kasus biasa.
*/

$stmt->bindParam(':min', $min, PDO::PARAM_STR); // PDO::PARAM_STR untuk float
$stmt->bindParam(':max', $max, PDO::PARAM_STR);
$stmt->execute();

$antara = $stmt->fetchAll();
echo "<p>IPK antara $min - $max (" . count($antara) . " mahasiswa):</p>";
echo "<ul>";
foreach ($antara as $row) {
    echo "<li>{$row['nama']} — {$row['ipk']}</li>";
}
echo "</ul>";


// ============================================================
// SECTION 3: INSERT — MENAMBAH DATA
// ============================================================

echo "<h2>3. INSERT — Menambah Data</h2>";

$data_baru = [
    'nama'    => 'Galih Permana',
    'npm'     => '50421999',
    'email'   => 'galih@email.com',
    'jurusan' => 'Teknik Informatika',
    'ipk'     => 3.45
];

$stmt = $pdo->prepare("
    INSERT INTO mahasiswa (nama, npm, email, jurusan, ipk)
    VALUES (:nama, :npm, :email, :jurusan, :ipk)
");

$stmt->execute($data_baru);
/*
  Jika key array sama dengan nama placeholder → bisa langsung pass array
  ':nama' cocok dengan key 'nama' — PDO otomatis mapping
*/

$id_baru = $pdo->lastInsertId();
/*
  lastInsertId() → ID dari baris yang baru di-INSERT
  Berguna untuk redirect atau tampilkan data yang baru dibuat
*/

echo "<p>✅ Mahasiswa baru ditambahkan! ID: <strong>$id_baru</strong></p>";
echo "<p>Nama: {$data_baru['nama']} | NPM: {$data_baru['npm']}</p>";

// rowCount() — berapa baris yang terpengaruh
echo "<p>Baris terpengaruh: " . $stmt->rowCount() . "</p>";


// ============================================================
// SECTION 4: UPDATE — MENGUBAH DATA
// ============================================================

echo "<h2>4. UPDATE — Mengubah Data</h2>";

$stmt = $pdo->prepare("
    UPDATE mahasiswa
    SET ipk = :ipk, email = :email
    WHERE npm = :npm
");

$stmt->execute([
    ':ipk'   => 3.55,
    ':email' => 'galih.baru@email.com',
    ':npm'   => '50421999'
]);

$affected = $stmt->rowCount();
echo "<p>✅ Update berhasil. Baris terpengaruh: <strong>$affected</strong></p>";

// Verifikasi
$stmt = $pdo->prepare("SELECT nama, ipk, email FROM mahasiswa WHERE npm = :npm");
$stmt->execute([':npm' => '50421999']);
$updated = $stmt->fetch();
echo "<p>Data terbaru: {$updated['nama']} | IPK: {$updated['ipk']} | Email: {$updated['email']}</p>";


// ============================================================
// SECTION 5: DELETE — MENGHAPUS DATA
// ============================================================

echo "<h2>5. DELETE — Menghapus Data</h2>";

/*
  Soft delete vs Hard delete:
  Hard delete → hapus baris dari database (permanen)
  Soft delete → set kolom aktif = 0 (data masih ada, hanya ditandai non-aktif)

  Soft delete lebih aman untuk data penting karena bisa dipulihkan.
*/

// Soft delete (direkomendasikan)
$stmt = $pdo->prepare("UPDATE mahasiswa SET aktif = 0 WHERE npm = :npm");
$stmt->execute([':npm' => '50421999']);
echo "<p>✅ Soft delete berhasil (aktif = 0)</p>";

// Hard delete (permanen)
$stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE npm = :npm");
$stmt->execute([':npm' => '50421999']);
echo "<p>✅ Hard delete berhasil (baris dihapus permanen)</p>";

// Verifikasi
$stmt = $pdo->query("SELECT COUNT(*) FROM mahasiswa");
echo "<p>Total mahasiswa sekarang: " . $stmt->fetchColumn() . "</p>";


// ============================================================
// SECTION 6: TRANSAKSI
// ============================================================

echo "<h2>6. Transaksi</h2>";

/*
  Transaksi = sekumpulan operasi SQL yang harus SEMUA berhasil
  atau SEMUA dibatalkan (atomik).

  Contoh: transfer uang
  - Kurangi saldo pengirim
  - Tambah saldo penerima
  Jika salah satu gagal → keduanya dibatalkan (tidak boleh setengah-setengah)

  ACID:
  Atomicity  → semua atau tidak sama sekali
  Consistency→ data selalu dalam kondisi valid
  Isolation  → transaksi tidak saling mengganggu
  Durability → data tersimpan permanen setelah commit
*/

try {
    $pdo->beginTransaction();
    /*
      beginTransaction() → mulai transaksi
      Semua query setelah ini masuk dalam satu transaksi
    */

    $jumlah_transfer = 500000;
    $npm_pengirim  = '50421905'; // Levi
    $npm_penerima  = '50421906'; // Andi

    // Cek saldo pengirim dulu
    $stmt = $pdo->prepare("SELECT saldo FROM rekening WHERE nama = 'Levi'");
    $stmt->execute();
    $saldo = $stmt->fetchColumn();

    if ($saldo < $jumlah_transfer) {
        throw new Exception("Saldo tidak cukup! Saldo: Rp " . number_format($saldo));
    }

    // Kurangi saldo pengirim
    $stmt = $pdo->prepare("UPDATE rekening SET saldo = saldo - :jumlah WHERE nama = 'Levi'");
    $stmt->execute([':jumlah' => $jumlah_transfer]);

    // Tambah saldo penerima
    $stmt = $pdo->prepare("UPDATE rekening SET saldo = saldo + :jumlah WHERE nama = 'Andi'");
    $stmt->execute([':jumlah' => $jumlah_transfer]);

    $pdo->commit();
    /*
      commit() → simpan semua perubahan dalam transaksi ini
    */

    echo "<p>✅ Transfer Rp " . number_format($jumlah_transfer) . " berhasil!</p>";

    // Cek saldo setelah transfer
    $stmt = $pdo->query("SELECT nama, saldo FROM rekening ORDER BY nama");
    $rekening = $stmt->fetchAll();
    echo "<ul>";
    foreach ($rekening as $r) {
        echo "<li>{$r['nama']}: Rp " . number_format($r['saldo']) . "</li>";
    }
    echo "</ul>";

} catch (Exception $e) {
    $pdo->rollBack();
    /*
      rollBack() → batalkan semua perubahan dalam transaksi ini
      Data kembali ke kondisi sebelum beginTransaction()
    */
    echo "<p style='color:red'>❌ Transaksi dibatalkan: " . $e->getMessage() . "</p>";
}


// ============================================================
// SECTION 7: FETCH MODE
// ============================================================

echo "<h2>7. Fetch Mode</h2>";

/*
  PDO::FETCH_ASSOC  → array associative ["nama" => "Levi"] (default kita set)
  PDO::FETCH_OBJ    → stdClass object $row->nama
  PDO::FETCH_CLASS  → mapping ke class tertentu
  PDO::FETCH_NUM    → array numerik [0 => "Levi"]
  PDO::FETCH_BOTH   → gabungan ASSOC + NUM
*/

// FETCH_OBJ
$stmt = $pdo->query("SELECT id, nama, npm FROM mahasiswa LIMIT 3");
$rows = $stmt->fetchAll(PDO::FETCH_OBJ);

echo "<h3>FETCH_OBJ (akses pakai ->):</h3>";
echo "<ul>";
foreach ($rows as $row) {
    echo "<li>{$row->nama} ({$row->npm})</li>"; // akses pakai ->
}
echo "</ul>";

// FETCH_CLASS — mapping langsung ke class PHP
class MahasiswaModel {
    public int $id;
    public string $nama;
    public string $npm;
    public float $ipk;

    public function getLabel(): string {
        return "{$this->nama} - IPK {$this->ipk}";
    }
}

$stmt = $pdo->query("SELECT id, nama, npm, ipk FROM mahasiswa LIMIT 3");
$stmt->setFetchMode(PDO::FETCH_CLASS, MahasiswaModel::class);
$objects = $stmt->fetchAll();

echo "<h3>FETCH_CLASS (mapping ke class):</h3>";
echo "<ul>";
foreach ($objects as $obj) {
    echo "<li>" . $obj->getLabel() . "</li>"; // bisa akses method!
}
echo "</ul>";


// ============================================================
// SECTION 8: HELPER FUNCTION — REUSABLE CODE
// ============================================================

echo "<h2>8. Helper Functions</h2>";

/*
  Di project nyata, operasi database dibungkus dalam fungsi atau class
  agar tidak menulis ulang kode yang sama berkali-kali.
*/

/**
 * Ambil semua mahasiswa dengan filter opsional
 */
function getMahasiswa(PDO $pdo, array $filter = [], int $limit = 0): array {
    $sql    = "SELECT * FROM mahasiswa WHERE 1=1";
    $params = [];

    if (!empty($filter['jurusan'])) {
        $sql .= " AND jurusan = :jurusan";
        $params[':jurusan'] = $filter['jurusan'];
    }

    if (!empty($filter['min_ipk'])) {
        $sql .= " AND ipk >= :min_ipk";
        $params[':min_ipk'] = $filter['min_ipk'];
    }

    if (!empty($filter['aktif'])) {
        $sql .= " AND aktif = :aktif";
        $params[':aktif'] = $filter['aktif'];
    }

    $sql .= " ORDER BY nama ASC";

    if ($limit > 0) {
        $sql .= " LIMIT :limit";
        $params[':limit'] = $limit;
    }

    $stmt = $pdo->prepare($sql);

    // Bind LIMIT sebagai integer
    if ($limit > 0) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        unset($params[':limit']);
    }

    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Cari mahasiswa by NPM
 */
function getMahasiswaByNPM(PDO $pdo, string $npm): ?array {
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE npm = :npm");
    $stmt->execute([':npm' => $npm]);
    $result = $stmt->fetch();
    return $result ?: null; // return null jika tidak ditemukan
}

/**
 * Insert mahasiswa baru — return ID yang baru dibuat
 */
function insertMahasiswa(PDO $pdo, array $data): int {
    $stmt = $pdo->prepare("
        INSERT INTO mahasiswa (nama, npm, email, jurusan, ipk)
        VALUES (:nama, :npm, :email, :jurusan, :ipk)
    ");
    $stmt->execute($data);
    return (int) $pdo->lastInsertId();
}

// Test helper functions
$ti_mhs = getMahasiswa($pdo, ['jurusan' => 'Teknik Informatika', 'min_ipk' => 3.0]);
echo "<p>Mahasiswa TI IPK ≥ 3.0: " . count($ti_mhs) . " orang</p>";

$levi = getMahasiswaByNPM($pdo, '50421905');
echo "<p>Cari NPM 50421905: " . ($levi ? $levi['nama'] : 'Tidak ditemukan') . "</p>";

?>

<style>
  body { font-family: 'Segoe UI', sans-serif; max-width: 960px; margin: 0 auto; padding: 2rem; color: #111827; line-height: 1.65; }
  h1   { color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; }
  h2   { color: #1e40af; margin-top: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.25rem; }
  h3   { color: #374151; margin-top: 1.25rem; }
  pre  { background: #0f172a; color: #e2e8f0; padding: 1rem; border-radius: 6px; overflow-x: auto; font-size: 0.85rem; }
  code { background: #f1f5f9; color: #e11d48; padding: 0.15em 0.4em; border-radius: 4px; }
  table { border-collapse: collapse; }
  th   { background: #2563eb; color: white; }
  tr:nth-child(even) { background: #f3f4f6; }
  p    { margin-bottom: 0.75rem; }
</style>