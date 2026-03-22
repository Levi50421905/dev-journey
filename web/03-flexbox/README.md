# 03 — Flexbox

**Topik:** CSS Flexbox — Layout 1 Dimensi  
**File:** `index.html` + `style.css`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Apa itu Flexbox?

Flexbox (Flexible Box Layout) adalah sistem layout CSS untuk mengatur elemen dalam **satu dimensi** — baris (horizontal) atau kolom (vertikal).

Sebelum Flexbox, layout horizontal yang fleksibel sangat susah — harus pakai `float`, `inline-block`, atau hack CSS lainnya yang semua punya quirks. Flexbox menyelesaikan ini dengan cara yang elegan.

---

## 📐 Konsep Inti

```
┌──────────────── FLEX CONTAINER ─────────────────┐
│ display: flex;                                   │
│  ┌──────┐  ┌──────┐  ┌──────┐                  │
│  │ Item │  │ Item │  │ Item │  ← flex items     │
│  └──────┘  └──────┘  └──────┘                  │
└─────────────────────────────────────────────────┘

Main Axis  →  diatur dengan justify-content
Cross Axis ↓  diatur dengan align-items
```

- **Flex Container** = parent yang diberi `display: flex`
- **Flex Items** = semua anak langsung container

---

## 🔧 Properti Container

| Properti | Nilai | Fungsi |
|---|---|---|
| `display` | `flex` | Aktifkan flexbox |
| `flex-direction` | `row` `column` `row-reverse` `column-reverse` | Arah main axis |
| `justify-content` | `flex-start` `flex-end` `center` `space-between` `space-around` `space-evenly` | Distribusi di main axis |
| `align-items` | `flex-start` `flex-end` `center` `stretch` `baseline` | Posisi di cross axis |
| `flex-wrap` | `nowrap` `wrap` `wrap-reverse` | Boleh pindah baris? |
| `gap` | `16px` | Jarak antar item |

## 🔧 Properti Item

| Properti | Nilai | Fungsi |
|---|---|---|
| `flex-grow` | `0` (default), `1`, angka | Ambil berapa bagian ruang sisa |
| `flex-shrink` | `1` (default), `0` | Boleh menyusut? |
| `flex-basis` | `auto`, `200px`, `30%` | Ukuran awal sebelum ruang dibagi |
| `flex` | `1` `0 0 200px` | Shorthand: grow shrink basis |
| `align-self` | sama dengan align-items | Override align-items per item |
| `order` | angka | Urutan tampil |

---

## 💡 Pola yang Paling Sering Dipakai

### 1. Navbar
```css
nav {
  display: flex;
  justify-content: space-between; /* logo kiri, menu kanan */
  align-items: center;             /* vertikal center */
}
```

### 2. Perfect Centering
```css
.container {
  display: flex;
  justify-content: center;
  align-items: center;
}
```

### 3. Card Grid Responsif
```css
.grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.card { flex: 1 1 200px; } /* minimal 200px, bisa tumbuh */
```

### 4. Sidebar + Konten
```css
.layout  { display: flex; gap: 2rem; }
.sidebar { flex: 0 0 260px; } /* ukuran tetap */
.main    { flex: 1; }          /* ambil sisa ruang */
```

### 5. Sticky Footer
```css
body   { display: flex; flex-direction: column; min-height: 100vh; }
main   { flex: 1; } /* dorong footer ke bawah */
footer { /* normal */ }
```

---

## ⚡ `flex: 1` — Yang Paling Sering Dipakai

```css
flex: 1;
/* Sama dengan: flex-grow: 1; flex-shrink: 1; flex-basis: 0; */
/* Hasil: semua item dengan flex:1 punya lebar sama rata */
```

---

## ❓ Flexbox vs Grid

| | Flexbox | Grid |
|---|---|---|
| Dimensi | 1D — baris OR kolom | 2D — baris AND kolom |
| Kontrol | Item menentukan ukuran | Layout menentukan ukuran |
| Cocok untuk | Navbar, komponen, centering | Layout halaman, dashboard |

**Aturan mudah:** Kalau berpikir dalam satu baris/kolom → Flexbox. Kalau berpikir dalam grid dua arah → Grid.

---

## 🗂️ Isi File

### `index.html`
6 section demo visual interaktif:
1. Konsep Container & Items + diagram sumbu
2. `flex-direction` — 4 nilai
3. `justify-content` — 6 nilai
4. `align-items` — 4 nilai
5. Properti item: `flex-grow`, `flex-shrink`, `flex`, `align-self`, `flex-wrap`, `gap`
6. 5 use case nyata: navbar, card grid, centering, sidebar layout, sticky footer

### `style.css`
CSS semua demo termasuk komentar penjelasan di setiap properti flexbox yang dipakai.

---

## 🔗 Referensi

- [MDN Flexbox](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_flexible_box_layout)
- [CSS Tricks — A Guide to Flexbox](https://css-tricks.com/snippets/css/a-guide-to-flexbox/)
- [Flexbox Froggy](https://flexboxfroggy.com/) — game belajar flexbox

---

## 🚀 Cara Buka

Buka `index.html` di browser. Coba resize jendela browser untuk melihat card grid menyesuaikan kolom secara otomatis.