# 04 — CSS Grid

**Topik:** CSS Grid — Layout 2 Dimensi  
**File:** `index.html` + `style.css`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Apa itu CSS Grid?

CSS Grid adalah sistem layout **2 dimensi** — mengatur elemen dalam baris DAN kolom sekaligus. Ini perbedaan utamanya dengan Flexbox yang hanya 1 dimensi.

---

## ❓ Grid vs Flexbox — Kapan Pakai Yang Mana?

| | Flexbox | Grid |
|---|---|---|
| Dimensi | 1D — baris OR kolom | 2D — baris AND kolom |
| Kontrol | Item menentukan ukuran | Layout menentukan ukuran |
| Cocok untuk | Navbar, komponen, centering | Layout halaman, dashboard, galeri |
| Cara berpikir | "Susun item dalam satu arah" | "Definisikan kotak, tempatkan item" |

**Aturan mudah:**
- Kalau berpikir dalam **satu baris atau kolom** → Flexbox
- Kalau berpikir dalam **kotak dua arah** → Grid
- Keduanya bisa dikombinasikan — Grid untuk layout halaman, Flexbox untuk komponen di dalamnya

---

## 📖 Konsep Penting

### Terminologi

```
Grid Container  → elemen dengan display: grid
Grid Items      → anak langsung container
Grid Lines      → garis pembatas (nomor dari 1)
Grid Track      → satu baris atau kolom
Grid Cell       → satu kotak (1 kolom × 1 baris)
Grid Area       → beberapa sel yang digabung
```

### Satuan fr (fraction)
```css
grid-template-columns: 1fr 1fr 1fr;
/* fr = bagian proporsional dari ruang yang tersedia */
/* 1fr 1fr 1fr = 3 kolom lebar sama rata */
/* 1fr 2fr 1fr = kolom tengah 2× lebih lebar */
```

---

## 🔧 Properti Container

| Properti | Contoh | Fungsi |
|---|---|---|
| `display` | `grid` | Aktifkan grid |
| `grid-template-columns` | `1fr 1fr 1fr` | Definisikan kolom |
| `grid-template-rows` | `80px 1fr auto` | Definisikan baris |
| `grid-template-areas` | `"header header"` | Layout dengan nama |
| `gap` | `16px` | Jarak antar sel |
| `justify-items` | `center` | Posisi item di sel (horizontal) |
| `align-items` | `center` | Posisi item di sel (vertikal) |
| `justify-content` | `space-between` | Distribusi kolom di container |

## 🔧 Properti Item

| Properti | Contoh | Fungsi |
|---|---|---|
| `grid-column` | `1 / 3` atau `span 2` | Posisi & span kolom |
| `grid-row` | `1 / 3` atau `span 2` | Posisi & span baris |
| `grid-area` | `header` | Assign ke named area |
| `justify-self` | `center` | Posisi item di sel (horizontal) |
| `align-self` | `end` | Posisi item di sel (vertikal) |

---

## 💡 Pola yang Paling Sering Dipakai

### 1. Grid Kolom Sama Rata
```css
.grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
```

### 2. Layout Halaman (areas)
```css
.layout {
  display: grid;
  grid-template-columns: 240px 1fr;
  grid-template-areas:
    "header  header"
    "sidebar main"
    "footer  footer";
  gap: 1rem;
}
.header  { grid-area: header; }
.sidebar { grid-area: sidebar; }
.main    { grid-area: main; }
.footer  { grid-area: footer; }
```

### 3. Grid Responsif Otomatis (tanpa media query!)
```css
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
}
/* Otomatis menyesuaikan jumlah kolom berdasarkan lebar container */
```

### 4. Item Spanning
```css
.featured { grid-column: span 2; grid-row: span 2; }
/* Item ini mengambil 2 kolom × 2 baris */
```

---

## 🗂️ Isi File

### `index.html`
6 section demo visual:
1. Konsep dasar + terminologi grid
2. `grid-template-columns` — berbagai nilai (fr, px, repeat)
3. `grid-template-rows`, `gap`, dan item spanning
4. `grid-template-areas` — layout dengan nama area
5. `auto-fit` + `minmax()` — grid responsif otomatis
6. 3 use case nyata: layout halaman, galeri foto, dashboard

### `style.css`
CSS semua demo dengan komentar penjelasan di setiap properti grid.

---

## 🔗 Referensi

- [MDN CSS Grid](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_grid_layout)
- [CSS Tricks — A Complete Guide to Grid](https://css-tricks.com/snippets/css/complete-guide-grid/)
- [Grid Garden](https://cssgridgarden.com/) — game belajar CSS Grid

---

## 🚀 Cara Buka

Buka `index.html` di browser. Resize jendela untuk melihat `auto-fit` menyesuaikan kolom secara otomatis di Section 5 dan 6.