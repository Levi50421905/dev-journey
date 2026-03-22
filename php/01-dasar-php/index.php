<?php
/*
  ╔══════════════════════════════════════════════════════╗
  ║  File   : index.php                                 ║
  ║  Topik  : PHP Dasar — Sintaks, Variabel, Tipe Data  ║
  ║  Folder : php/01-dasar-php/                         ║
  ║  Author : Muhammad Alfarezzi Fallevi (50421905)     ║
  ║  Repo   : github.com/Levi50421905/dev-journey       ║
  ╚══════════════════════════════════════════════════════╝

  PHP (PHP: Hypertext Preprocessor) adalah bahasa scripting
  server-side untuk web. Artinya kode PHP dijalankan di SERVER,
  hasilnya (HTML) dikirim ke browser.

  Cara jalankan:
  1. Pakai XAMPP / Laragon → taruh di htdocs/ → buka localhost
  2. PHP built-in server: php -S localhost:8000
*/

// ============================================================
// SECTION 1: TAG PHP & OUTPUT
// ============================================================

/*
  Tag pembuka PHP: <?php
  Tag penutup PHP: ?> (opsional jika file pure PHP)
  Komentar:
    // satu baris
    # satu baris (alternatif)
    /* banyak baris * /

  Output ke browser:
    echo  → cetak string (lebih cepat)
    print → cetak string, return 1 (bisa dipakai dalam ekspresi)
    var_dump()   → cetak nilai + tipe data (untuk debug)
    print_r()    → cetak array/object yang mudah dibaca
*/

echo "<h1>01 — PHP Dasar</h1>";
echo "<p>Belajar PHP dari dasar dengan pemahaman <strong>kenapa</strong>.</p>";

// Titik koma WAJIB di akhir setiap statement
// echo "lupa titik koma" ← error!


// ============================================================
// SECTION 2: VARIABEL & TIPE DATA
// ============================================================

echo "<h2>2. Variabel & Tipe Data</h2>";

/*
  Variabel PHP:
  - Diawali dengan $ (dollar sign) — wajib!
  - Case-sensitive: $nama ≠ $Nama
  - Tipe data ditentukan otomatis (dynamic typing)
  - Tidak perlu deklarasi tipe sebelum pakai
*/

// String
$nama       = "Muhammad Alfarezzi Fallevi";
$kelas      = 'S1 Informatika';   // single quote juga valid
$npm        = "50421905";

// Integer
$umur       = 22;
$tahun_lulus = 2025;

// Float
$ipk        = 3.75;
$tinggi     = 170.5;

// Boolean
$is_lulus   = true;
$is_aktif   = false;

// NULL — variabel tanpa nilai
$alamat     = null;

// Tampilkan
echo "<h3>Tipe Data:</h3>";
echo "<pre>";
var_dump($nama);       // string(26) "Muhammad Alfarezzi Fallevi"
var_dump($umur);       // int(22)
var_dump($ipk);        // float(3.75)
var_dump($is_lulus);   // bool(true)
var_dump($alamat);     // NULL
echo "</pre>";

/*
  Double quote vs Single quote:
  $x = "Halo $nama";   → variabel di-parse → "Halo Muhammad..."
  $x = 'Halo $nama';   → variabel TIDAK di-parse → "Halo $nama"
  Single quote lebih cepat (tidak perlu parse variabel)
  Double quote lebih fleksibel (bisa interpolasi variabel)
*/

$salam = "Halo, $nama! Kelas: $kelas";
echo "<p>$salam</p>";

// Alternatif dengan kurung kurawal (lebih jelas)
$info = "IPK: {$ipk} | Lulus: {$tahun_lulus}";
echo "<p>$info</p>";


// ============================================================
// SECTION 3: OPERATOR
// ============================================================

echo "<h2>3. Operator</h2>";

// Aritmatika
$a = 10;
$b = 3;

echo "<pre>";
echo "a = $a, b = $b\n";
echo "a + b = " . ($a + $b) . "\n";    // 13
echo "a - b = " . ($a - $b) . "\n";    // 7
echo "a * b = " . ($a * $b) . "\n";    // 30
echo "a / b = " . ($a / $b) . "\n";    // 3.333...
echo "a % b = " . ($a % $b) . "\n";    // 1 (modulus/sisa bagi)
echo "a ** b = " . ($a ** $b) . "\n";  // 1000 (pangkat)
echo "</pre>";

// Assignment
$x = 5;
$x += 3;   // $x = $x + 3 = 8
$x -= 2;   // $x = $x - 2 = 6
$x *= 2;   // $x = $x * 2 = 12
$x /= 4;   // $x = $x / 4 = 3
$x .= "px"; // $x = $x . "px" = "3px" (string concatenation)

// Perbandingan
echo "<pre>";
echo "5 == '5'  : "; var_dump(5 == '5');   // true  (nilai sama, tipe diabaikan)
echo "5 === '5' : "; var_dump(5 === '5');  // false (nilai DAN tipe harus sama)
echo "5 != '5'  : "; var_dump(5 != '5');   // false
echo "5 !== '5' : "; var_dump(5 !== '5');  // true
echo "10 > 5   : "; var_dump(10 > 5);     // true
echo "10 <= 10  : "; var_dump(10 <= 10);  // true
echo "</pre>";

/*
  == vs ===
  PENTING! Selalu pakai === untuk perbandingan yang aman.
  == bisa menyebabkan bug:
  0 == "a" → true (PHP konversi "a" ke 0)
  0 === "a" → false (tipe berbeda)
*/

// String operator
$depan  = "Halo";
$belakang = "Dunia";
$gabung = $depan . ", " . $belakang . "!";  // . = concatenation
echo "<p>$gabung</p>";

// Ternary operator
$nilai = 75;
$status = ($nilai >= 60) ? "Lulus" : "Tidak Lulus";
echo "<p>Status: $status</p>";

// Null coalescing (PHP 7+)
$username = null;
$display = $username ?? "Guest";  // pakai $username, jika null pakai "Guest"
echo "<p>User: $display</p>";


// ============================================================
// SECTION 4: STRING FUNCTIONS
// ============================================================

echo "<h2>4. Fungsi String yang Sering Dipakai</h2>";

$teks = "  Belajar PHP di Universitas Gunadarma  ";

echo "<pre>";
echo "Original       : '$teks'\n";
echo "trim()         : '" . trim($teks) . "'\n";          // hapus spasi tepi
echo "strtolower()   : '" . strtolower($teks) . "'\n";    // huruf kecil semua
echo "strtoupper()   : '" . strtoupper($teks) . "'\n";    // huruf besar semua
echo "strlen()       : " . strlen(trim($teks)) . "\n";    // panjang string
echo "str_word_count : " . str_word_count(trim($teks)) . "\n"; // hitung kata
echo "str_replace()  : '" . str_replace("PHP", "PHP 8", trim($teks)) . "'\n";
echo "strpos()       : " . strpos(trim($teks), "PHP") . "\n"; // posisi substring
echo "substr()       : '" . substr(trim($teks), 0, 12) . "'\n"; // ambil sebagian
echo "ucfirst()      : '" . ucfirst(strtolower(trim($teks))) . "'\n"; // kapital awal
echo "ucwords()      : '" . ucwords(strtolower(trim($teks))) . "'\n"; // kapital tiap kata
echo "str_contains() : "; var_dump(str_contains($teks, "PHP")); // PHP 8+
echo "explode()      : "; print_r(explode(" ", "satu dua tiga")); // split ke array
echo "</pre>";

// sprintf — format string
$harga = 150000;
$formatted = sprintf("Rp %s", number_format($harga, 0, ',', '.'));
echo "<p>Harga: $formatted</p>";


// ============================================================
// SECTION 5: ARRAY
// ============================================================

echo "<h2>5. Array</h2>";

// --- 5.1 Indexed Array ---
echo "<h3>5.1 Indexed Array</h3>";

$buah = ["Apel", "Mangga", "Jeruk", "Pisang", "Durian"];
/*
  Index dimulai dari 0
  $buah[0] = "Apel"
  $buah[4] = "Durian"
*/

echo "<p>Buah ke-1: " . $buah[0] . "</p>";
echo "<p>Jumlah: " . count($buah) . "</p>";

// Tambah elemen
$buah[] = "Semangka";           // tambah di akhir
array_push($buah, "Melon");     // sama dengan di atas
array_unshift($buah, "Anggur"); // tambah di awal

// Hapus elemen
array_pop($buah);    // hapus elemen terakhir
array_shift($buah);  // hapus elemen pertama

echo "<pre>Setelah modifikasi: ";
print_r($buah);
echo "</pre>";

// Sorting
sort($buah);          // urutkan ascending (modifikasi array asli)
rsort($buah);         // urutkan descending

// Slice
$tiga_pertama = array_slice($buah, 0, 3); // ambil 3 elemen dari index 0

// Search
$ada_mangga = in_array("Mangga", $buah); // true/false
$index_mangga = array_search("Mangga", $buah); // index atau false

echo "<p>Ada Mangga: "; var_dump($ada_mangga); echo "</p>";

// --- 5.2 Associative Array ---
echo "<h3>5.2 Associative Array</h3>";
/*
  Key-value pairs — seperti object/dictionary di bahasa lain
  Key bisa string atau integer
*/

$mahasiswa = [
    "nama"    => "Levi Alfarezzi",
    "npm"     => "50421905",
    "kelas"   => "4IA17",
    "ipk"     => 3.75,
    "aktif"   => true
];

echo "<p>Nama: " . $mahasiswa["nama"] . "</p>";
echo "<p>NPM: " . $mahasiswa["npm"] . "</p>";

// Tambah & ubah
$mahasiswa["jurusan"] = "Teknik Informatika";
$mahasiswa["ipk"] = 3.80; // update

// Hapus
unset($mahasiswa["aktif"]);

// Cek key ada atau tidak
if (array_key_exists("nama", $mahasiswa)) {
    echo "<p>Key 'nama' ada.</p>";
}

// Ambil semua key / semua value
$keys   = array_keys($mahasiswa);
$values = array_values($mahasiswa);

echo "<pre>Data mahasiswa: ";
print_r($mahasiswa);
echo "</pre>";

// --- 5.3 Multidimensional Array ---
echo "<h3>5.3 Multidimensional Array</h3>";

$kelas_4ia17 = [
    [
        "nama" => "Levi",
        "npm"  => "50421905",
        "ipk"  => 3.75
    ],
    [
        "nama" => "Andi",
        "npm"  => "50421906",
        "ipk"  => 3.50
    ],
    [
        "nama" => "Sari",
        "npm"  => "50421907",
        "ipk"  => 3.90
    ]
];

// Akses
echo "<p>Mahasiswa pertama: " . $kelas_4ia17[0]["nama"] . "</p>";
echo "<p>IPK ketiga: " . $kelas_4ia17[2]["ipk"] . "</p>";

// --- 5.4 Array Functions Berguna ---
echo "<h3>5.4 Fungsi Array Penting</h3>";

$angka = [3, 1, 4, 1, 5, 9, 2, 6, 5, 3];

echo "<pre>";
echo "Original  : "; print_r($angka);
echo "array_unique() : "; print_r(array_unique($angka));  // hapus duplikat
echo "array_sum()    : " . array_sum($angka) . "\n";       // jumlah semua
echo "max()          : " . max($angka) . "\n";             // nilai terbesar
echo "min()          : " . min($angka) . "\n";             // nilai terkecil
echo "array_reverse(): "; print_r(array_reverse($angka));  // balik urutan
echo "implode()      : " . implode(", ", $angka) . "\n";   // array → string
echo "</pre>";

// array_map — transformasi tiap elemen
$kuadrat = array_map(fn($n) => $n * $n, [1, 2, 3, 4, 5]);
echo "<pre>array_map (kuadrat): "; print_r($kuadrat); echo "</pre>";

// array_filter — saring elemen
$genap = array_filter([1, 2, 3, 4, 5, 6], fn($n) => $n % 2 === 0);
echo "<pre>array_filter (genap): "; print_r($genap); echo "</pre>";

// array_reduce — reduksi ke satu nilai
$total = array_reduce([1, 2, 3, 4, 5], fn($carry, $item) => $carry + $item, 0);
echo "<p>array_reduce (total): $total</p>";


// ============================================================
// SECTION 6: CONTROL FLOW
// ============================================================

echo "<h2>6. Control Flow</h2>";

// --- If / Elseif / Else ---
$nilai = 85;

if ($nilai >= 90) {
    $grade = "A";
} elseif ($nilai >= 80) {
    $grade = "B";
} elseif ($nilai >= 70) {
    $grade = "C";
} elseif ($nilai >= 60) {
    $grade = "D";
} else {
    $grade = "E";
}

echo "<p>Nilai $nilai → Grade: $grade</p>";

// --- Match expression (PHP 8) ---
$hari = "Senin";
$tipe = match($hari) {
    "Senin", "Selasa", "Rabu", "Kamis", "Jumat" => "Hari Kerja",
    "Sabtu", "Minggu" => "Akhir Pekan",
    default => "Tidak diketahui"
};
echo "<p>$hari adalah $tipe</p>";

// --- Switch ---
$bulan = 6;
switch ($bulan) {
    case 12:
    case 1:
    case 2:
        $musim = "Puncak Hujan";
        break;
    case 6:
    case 7:
    case 8:
        $musim = "Musim Kemarau";
        break;
    default:
        $musim = "Peralihan";
}
echo "<p>Bulan $bulan: $musim</p>";

// --- Loop ---
echo "<h3>Loop:</h3>";

// For
echo "<p>For: ";
for ($i = 1; $i <= 5; $i++) {
    echo $i . " ";
}
echo "</p>";

// While
echo "<p>While: ";
$i = 1;
while ($i <= 5) {
    echo $i . " ";
    $i++;
}
echo "</p>";

// Foreach — untuk array (paling sering dipakai)
echo "<p>Foreach buah: ";
$buah_list = ["Apel", "Mangga", "Jeruk"];
foreach ($buah_list as $item) {
    echo $item . " ";
}
echo "</p>";

// Foreach dengan key
echo "<pre>Foreach mahasiswa (key => value):\n";
foreach ($mahasiswa as $key => $value) {
    echo "  $key: $value\n";
}
echo "</pre>";

// Break & Continue
echo "<p>Skip angka 3: ";
for ($i = 1; $i <= 5; $i++) {
    if ($i === 3) continue; // skip iterasi ini
    echo $i . " ";
}
echo "</p>";


// ============================================================
// SECTION 7: FUNGSI
// ============================================================

echo "<h2>7. Fungsi</h2>";

/*
  Fungsi = blok kode yang bisa dipanggil berulang kali.
  Definisi harus sebelum dipanggil (atau di file yang di-include).
*/

// Fungsi dasar
function sapa(string $nama): string {
    return "Halo, $nama!";
    /*
      Type hint (PHP 7+):
      string $nama → parameter harus string
      : string     → return value harus string
      Membantu deteksi error lebih awal
    */
}

echo "<p>" . sapa("Levi") . "</p>";

// Default parameter
function hitung_luas_persegi(float $sisi = 1.0): float {
    return $sisi * $sisi;
}

echo "<p>Luas persegi sisi 5: " . hitung_luas_persegi(5) . "</p>";
echo "<p>Luas default (sisi=1): " . hitung_luas_persegi() . "</p>";

// Multiple return values (pakai array)
function min_max(array $arr): array {
    return [
        "min" => min($arr),
        "max" => max($arr),
        "avg" => array_sum($arr) / count($arr)
    ];
}

$hasil = min_max([3, 7, 1, 9, 4, 6]);
echo "<p>Min: {$hasil['min']}, Max: {$hasil['max']}, Avg: {$hasil['avg']}</p>";

// Variadic function — jumlah parameter tidak terbatas
function jumlahkan(int ...$angka): int {
    return array_sum($angka);
}

echo "<p>Jumlah 1+2+3+4+5 = " . jumlahkan(1, 2, 3, 4, 5) . "</p>";

// Anonymous function (closure)
$kali_dua = function(int $n): int {
    return $n * 2;
};

echo "<p>Kali dua 7 = " . $kali_dua(7) . "</p>";

// Arrow function (PHP 7.4+) — sintaks lebih pendek
$kali_tiga = fn(int $n) => $n * 3;
echo "<p>Kali tiga 7 = " . $kali_tiga(7) . "</p>";

// Rekursif
function faktorial(int $n): int {
    if ($n <= 1) return 1;           // base case
    return $n * faktorial($n - 1);  // recursive case
}

echo "<p>5! = " . faktorial(5) . "</p>"; // 120


// ============================================================
// SECTION 8: OOP — OBJECT-ORIENTED PROGRAMMING
// ============================================================

echo "<h2>8. OOP — Object-Oriented Programming</h2>";

/*
  OOP = paradigma pemrograman berbasis objek.
  Objek = data (properties) + fungsi (methods) dalam satu entitas.

  Konsep utama:
  - Class      → blueprint/template untuk membuat objek
  - Object     → instance dari class
  - Property   → variabel milik class
  - Method     → fungsi milik class
  - Constructor → method khusus yang dipanggil saat objek dibuat
*/

// --- Class Dasar ---
class Mahasiswa {

    // Properties
    public string $nama;
    public string $npm;
    private string $password; // private = hanya bisa diakses dari dalam class
    protected float $ipk;     // protected = bisa diakses oleh child class

    /*
      Visibility:
      public    → bisa diakses dari mana saja
      private   → hanya bisa diakses dari dalam class ini
      protected → bisa diakses dari dalam class + child class
    */

    // Constructor
    public function __construct(string $nama, string $npm, float $ipk) {
        $this->nama = $nama;
        $this->npm  = $npm;
        $this->ipk  = $ipk;
        $this->password = "default123"; // set default
        /*
          $this → merujuk ke objek itu sendiri
          $this->nama = mengakses property 'nama' milik objek ini
        */
    }

    // Method
    public function perkenalan(): string {
        return "Saya {$this->nama} ({$this->npm}), IPK: {$this->ipk}";
    }

    public function getStatus(): string {
        return match(true) {
            $this->ipk >= 3.5  => "Cumlaude",
            $this->ipk >= 3.0  => "Sangat Memuaskan",
            $this->ipk >= 2.75 => "Memuaskan",
            default            => "Cukup"
        };
    }

    // Getter & Setter untuk private property
    public function getIPK(): float {
        return $this->ipk;
    }

    public function setIPK(float $ipk): void {
        if ($ipk < 0 || $ipk > 4) {
            throw new InvalidArgumentException("IPK harus antara 0-4");
        }
        $this->ipk = $ipk;
    }

    // Magic method __toString — dipanggil saat objek di-echo
    public function __toString(): string {
        return "{$this->nama} ({$this->npm})";
    }
}

// Buat objek
$mhs1 = new Mahasiswa("Levi Alfarezzi", "50421905", 3.75);
$mhs2 = new Mahasiswa("Andi Santoso", "50421906", 3.20);

echo "<p>" . $mhs1->perkenalan() . "</p>";
echo "<p>Status: " . $mhs1->getStatus() . "</p>";
echo "<p>Objek: $mhs1</p>"; // pakai __toString

// Update IPK
$mhs1->setIPK(3.85);
echo "<p>IPK baru: " . $mhs1->getIPK() . "</p>";

// --- Inheritance (Pewarisan) ---
echo "<h3>Inheritance</h3>";

class MahasiswaAktif extends Mahasiswa {
    /*
      extends = MahasiswaAktif mewarisi semua public & protected
      dari class Mahasiswa
    */

    private int $semester;
    private array $matakuliah = [];

    public function __construct(string $nama, string $npm, float $ipk, int $semester) {
        parent::__construct($nama, $npm, $ipk); // panggil constructor parent
        $this->semester = $semester;
    }

    public function daftarMatakuliah(string $matkul): void {
        $this->matakuliah[] = $matkul;
    }

    public function getSemester(): int {
        return $this->semester;
    }

    // Override method parent
    public function perkenalan(): string {
        $parent = parent::perkenalan(); // panggil method parent
        return "$parent | Semester: {$this->semester}";
    }

    public function getMatakuliah(): array {
        return $this->matakuliah;
    }
}

$aktif = new MahasiswaAktif("Levi", "50421905", 3.75, 8);
$aktif->daftarMatakuliah("Tugas Akhir");
$aktif->daftarMatakuliah("Keamanan Sistem Informasi");

echo "<p>" . $aktif->perkenalan() . "</p>";
echo "<pre>Matakuliah: "; print_r($aktif->getMatakuliah()); echo "</pre>";

// --- Interface ---
echo "<h3>Interface</h3>";

interface Exportable {
    /*
      Interface = kontrak — class yang mengimplementasikan
      WAJIB mendefinisikan semua method di interface ini.
    */
    public function exportCSV(): string;
    public function exportJSON(): string;
}

class DataMahasiswa implements Exportable {
    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function exportCSV(): string {
        $baris = ["nama,npm,ipk"];
        foreach ($this->data as $d) {
            $baris[] = "{$d['nama']},{$d['npm']},{$d['ipk']}";
        }
        return implode("\n", $baris);
    }

    public function exportJSON(): string {
        return json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

$data = new DataMahasiswa([
    ["nama" => "Levi", "npm" => "50421905", "ipk" => 3.75],
    ["nama" => "Andi", "npm" => "50421906", "ipk" => 3.20],
]);

echo "<pre>CSV:\n" . $data->exportCSV() . "</pre>";
echo "<pre>JSON:\n" . $data->exportJSON() . "</pre>";

// --- Static Method & Property ---
echo "<h3>Static</h3>";

class Counter {
    private static int $count = 0;
    /*
      static = milik CLASS, bukan milik object.
      Bisa diakses tanpa membuat object.
    */

    public static function increment(): void {
        self::$count++;
    }

    public static function getCount(): int {
        return self::$count;
    }
}

Counter::increment();
Counter::increment();
Counter::increment();
echo "<p>Total increment: " . Counter::getCount() . "</p>"; // 3


// ============================================================
// SECTION 9: ERROR HANDLING
// ============================================================

echo "<h2>9. Error Handling</h2>";

// Try / Catch / Finally
try {
    $angka = 10;
    $pembagi = 0;

    if ($pembagi === 0) {
        throw new Exception("Tidak bisa membagi dengan nol!");
        /*
          throw → lempar exception
          Exception adalah class bawaan PHP
        */
    }

    $hasil = $angka / $pembagi;
    echo "<p>Hasil: $hasil</p>";

} catch (InvalidArgumentException $e) {
    // catch exception spesifik dulu
    echo "<p>InvalidArgument: " . $e->getMessage() . "</p>";

} catch (Exception $e) {
    // catch exception umum
    echo "<p>Error: " . $e->getMessage() . "</p>";

} finally {
    // always runs — dengan atau tanpa error
    echo "<p>Finally: blok ini selalu dijalankan.</p>";
}

// Custom Exception
class DatabaseException extends Exception {
    public function __construct(string $message, private string $query = "") {
        parent::__construct($message);
    }

    public function getQuery(): string {
        return $this->query;
    }
}

try {
    throw new DatabaseException("Koneksi database gagal", "SELECT * FROM users");
} catch (DatabaseException $e) {
    echo "<p>DB Error: " . $e->getMessage() . "</p>";
    echo "<p>Query: " . $e->getQuery() . "</p>";
}


// ============================================================
// SECTION 10: INCLUDE & REQUIRE
// ============================================================

echo "<h2>10. Include & Require</h2>";

/*
  Memisahkan kode ke file terpisah:

  include 'file.php'       → include file, WARNING jika tidak ada
  require 'file.php'       → include file, ERROR (fatal) jika tidak ada
  include_once 'file.php'  → include, tapi hanya sekali (skip jika sudah)
  require_once 'file.php'  → require, tapi hanya sekali

  Pola umum:
  - config.php → koneksi database, konstanta
  - functions.php → fungsi-fungsi helper
  - header.php, footer.php → template HTML

  require_once 'config.php';
  require_once 'functions.php';
  include 'header.php';
*/

echo "<p>Di project nyata, kode dipisah ke banyak file menggunakan <code>require_once</code>.</p>";
echo "<p>Lihat folder <code>03-perpustakaan/</code> untuk contoh struktur file nyata.</p>";

?>

<!-- HTML di bawah ini akan langsung dirender oleh browser -->
<style>
  body { font-family: 'Segoe UI', sans-serif; max-width: 900px; margin: 0 auto; padding: 2rem; color: #111827; line-height: 1.6; }
  h1   { color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; }
  h2   { color: #1e40af; margin-top: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.25rem; }
  h3   { color: #374151; }
  pre  { background: #0f172a; color: #e2e8f0; padding: 1rem; border-radius: 6px; overflow-x: auto; font-size: 0.85rem; }
  code { background: #f1f5f9; color: #e11d48; padding: 0.15em 0.4em; border-radius: 4px; font-size: 0.9em; }
  p    { margin-bottom: 0.75rem; }
</style>