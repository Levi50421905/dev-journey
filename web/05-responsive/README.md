# 05 — Responsive Design

**Topik:** Responsive Design — Mobile-First, Media Query, Fluid Typography  
**File:** `index.html` + `style.css`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Apa itu Responsive Design?

Responsive Design adalah teknik membuat halaman web yang tampilannya otomatis menyesuaikan dengan ukuran layar device — dari HP 320px hingga monitor 2560px — menggunakan **satu file HTML dan CSS yang sama**.

---

## 📱 Mobile First — Pendekatan yang Dipakai

```css
/* 1. Tulis CSS untuk mobile dulu */
.grid { display: block; }

/* 2. Tambah untuk tablet */
@media (min-width: 768px) {
  .grid { display: grid; grid-template-columns: 1fr 1fr; }
}

/* 3. Tambah untuk desktop */
@media (min-width: 1024px) {
  .grid { grid-template-columns: repeat(3, 1fr); }
}
```

**Kenapa Mobile First?**
- Browser mobile tidak perlu download dan override CSS desktop
- Lebih efisien — tambah kompleksitas, bukan kurangi
- Sesuai fakta: mayoritas traffic web dari mobile

---

## 📐 Breakpoint yang Dipakai

| Breakpoint | Ukuran | Target Device |
|---|---|---|
| Default | < 640px | Mobile kecil & besar |
| `min-width: 640px` | 640px+ | Mobile besar |
| `min-width: 768px` | 768px+ | Tablet portrait |
| `min-width: 1024px` | 1024px+ | Laptop & Desktop |

---

## 🔧 Teknik Utama

### 1. Viewport Meta Tag (WAJIB)
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

### 2. Media Query
```css
@media (min-width: 768px) { /* CSS untuk tablet ke atas */ }
@media (max-width: 767px) { /* CSS hanya untuk mobile */ }
@media (min-width: 768px) and (max-width: 1023px) { /* hanya tablet */ }
```

### 3. Fluid Typography dengan clamp()
```css
/* min, ideal (relatif ke viewport), max */
h1 { font-size: clamp(1.5rem, 5vw, 2.8rem); }
/* Otomatis responsif TANPA media query */
```

### 4. Container Responsif
```css
.container {
  width: 100%;
  padding: 0 1rem;    /* mobile */
  margin: 0 auto;
}

@media (min-width: 1024px) {
  .container { max-width: 1100px; padding: 0 2rem; }
}
```

### 5. Grid Responsif Otomatis
```css
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
}
/* Tanpa media query! Otomatis menyesuaikan jumlah kolom */
```

### 6. Gambar Responsif
```css
img { max-width: 100%; height: auto; display: block; }
```

### 7. Tabel Responsif
```css
.table-wrapper { overflow-x: auto; } /* scroll horizontal di mobile */
table { min-width: 500px; }          /* paksa scroll */
```

### 8. Hamburger Menu
```css
/* Mobile: tampil hamburger */
.hamburger { display: flex; }
.main-nav  { display: none; }
.main-nav.open { display: block; }

/* Tablet ke atas: nav inline, hamburger hilang */
@media (min-width: 768px) {
  .hamburger { display: none; }
  .main-nav  { display: flex !important; }
}
```

---

## 🗂️ Isi File

### `index.html`
Halaman responsif lengkap dengan:
- **Header** — hamburger menu di mobile, nav inline di tablet+
- **Hero** — vertikal di mobile, horizontal di tablet+
- **5 section** — media query, breakpoint, fluid typography, gambar, contoh
- **Card grid** — 1/2/3 kolom sesuai ukuran layar
- **Tabel responsif** — scroll horizontal di mobile
- **Footer** — 1/2/3 kolom sesuai ukuran layar

### `style.css`
Seluruh CSS ditulis **mobile first** — CSS default untuk mobile, `@media (min-width: ...)` untuk layar lebih besar. Setiap teknik responsif diberi komentar penjelasan.

---

## 🔗 Referensi

- [MDN Responsive Design](https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Responsive_Design)
- [MDN Media Queries](https://developer.mozilla.org/en-US/docs/Web/CSS/Media_Queries)
- [web.dev — Responsive Web Design](https://web.dev/learn/design/)

---

## 🚀 Cara Buka

Buka `index.html` di browser lalu **resize jendela** untuk melihat semua perubahan responsif. Atau buka DevTools (`F12`) → toggle device toolbar untuk simulasi HP/tablet.