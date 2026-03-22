# 01 — PHP Dasar

**Topik:** Sintaks PHP, Variabel, Array, Control Flow, Fungsi, OOP  
**File:** `index.php`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Apa itu PHP?

PHP (PHP: Hypertext Preprocessor) adalah bahasa scripting **server-side** untuk web. Artinya kode PHP dijalankan di **server**, hasilnya (HTML) dikirim ke browser.

```
Browser → Request → Server (PHP dijalankan) → Response (HTML) → Browser
```

Berbeda dengan JavaScript yang berjalan di browser (client-side).

---

## 🚀 Cara Jalankan

```bash
# Opsi 1: PHP built-in server
php -S localhost:8000
# Buka: http://localhost:8000/index.php

# Opsi 2: XAMPP / Laragon
# Taruh di: htdocs/dev-journey/php/01-dasar-php/
# Buka: http://localhost/dev-journey/php/01-dasar-php/
```

---

## 📖 Konsep Penting

### Variabel
```php
$nama = "Levi";    // selalu diawali $
$umur = 22;        // tipe ditentukan otomatis
$ipk  = 3.75;
$aktif = true;
$kosong = null;
```

### Double vs Single Quote
```php
$nama = "Levi";
echo "Halo $nama";   // → Halo Levi (variabel di-parse)
echo 'Halo $nama';   // → Halo $nama (tidak di-parse, lebih cepat)
```

### `==` vs `===`
```php
5 == "5"   // true  (nilai sama, tipe diabaikan) — HINDARI
5 === "5"  // false (nilai DAN tipe harus sama)  — GUNAKAN INI
```

### Array
```php
// Indexed
$buah = ["Apel", "Mangga", "Jeruk"];
echo $buah[0]; // Apel

// Associative (key-value)
$mhs = ["nama" => "Levi", "npm" => "50421905"];
echo $mhs["nama"]; // Levi

// Multidimensional
$kelas[0]["nama"] = "Levi";
```

### Foreach — Loop Paling Sering Dipakai di PHP
```php
foreach ($array as $item) { ... }
foreach ($array as $key => $value) { ... }
```

### Fungsi dengan Type Hint (PHP 7+)
```php
function sapa(string $nama): string {
    return "Halo, $nama!";
}
```

### OOP Dasar
```php
class Mahasiswa {
    public string $nama;
    private float $ipk;

    public function __construct(string $nama, float $ipk) {
        $this->nama = $nama;
        $this->ipk  = $ipk;
    }

    public function perkenalan(): string {
        return "Saya {$this->nama}, IPK: {$this->ipk}";
    }
}

$mhs = new Mahasiswa("Levi", 3.75);
echo $mhs->perkenalan();
```

### Visibility
| Keyword | Akses dari |
|---|---|
| `public` | Mana saja |
| `protected` | Class sendiri + child class |
| `private` | Hanya class sendiri |

---

## 🗂️ Isi File `index.php`

| Section | Topik |
|---|---|
| 1 | Tag PHP, `echo`, `var_dump()`, `print_r()` |
| 2 | Variabel & tipe data (string, int, float, bool, null) |
| 3 | Operator (aritmatika, perbandingan `==` vs `===`, ternary, null coalescing) |
| 4 | Fungsi string: `trim`, `strlen`, `str_replace`, `explode`, dll |
| 5 | Array: indexed, associative, multidimensional, `array_map/filter/reduce` |
| 6 | Control flow: if/elseif, `match`, switch, for, while, foreach |
| 7 | Fungsi: type hint, default param, variadic, closure, arrow function, rekursif |
| 8 | OOP: class, object, property, method, inheritance, interface, static |
| 9 | Error handling: try/catch/finally, custom exception |
| 10 | include & require — struktur multi-file |

---

## 🆕 Fitur PHP 8 yang Dipakai

| Fitur | Contoh |
|---|---|
| `match` expression | `match($val) { 1 => "a", default => "b" }` |
| Named arguments | `array_slice(arr: $arr, offset: 0, length: 3)` |
| `str_contains()` | `str_contains($str, "PHP")` |
| Arrow function | `fn($n) => $n * 2` |
| Constructor promotion | `__construct(private string $nama)` |
| Nullsafe operator | `$obj?->method()` |

---

## 🔗 Referensi

- [PHP Manual](https://www.php.net/manual/en/)
- [PHP 8 New Features](https://www.php.net/releases/8.0/)
- [PHP The Right Way](https://phptherightway.com/)

---

## ➡️ Selanjutnya

Setelah memahami dasar PHP, lanjut ke:  
**`02-php-mysql/`** — Koneksi database, PDO, query CRUD dari PHP