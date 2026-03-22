# 🌐 Web — HTML & CSS

Dokumentasi belajar HTML & CSS dengan pendekatan **"paham dulu, hapal belakangan"**.  
Sudah bisa pakai sejak SMK — sekarang belajar *kenapa*-nya.  
**Muhammad Alfarezzi Fallevi** · 4IA17 · 50421905

---

## 🧠 Filosofi

> Jangan hapal kode. Pahami kenapa kode itu ada.

Setiap file HTML dan CSS di folder ini dilengkapi komentar penjelasan di setiap baris — bukan sekadar contoh kode, tapi alasan di balik setiap keputusan desain.

---

## 📁 Folder

| Folder | Topik | Highlight |
|---|---|---|
| `01-html-dasar/` | HTML Semantik & CSS Dasar | Elemen semantik, form lengkap, tabel, box model, selector, positioning |
| `02-css-dasar/` | Cascade & Specificity | Urutan aturan, skor selector, display, pseudo-class, pseudo-element, transisi |
| `03-flexbox/` | CSS Flexbox | 6 section demo + 5 use case: navbar, card grid, centering, sidebar, sticky footer |
| `04-grid/` | CSS Grid | Template columns/rows/areas, auto-fit + minmax, galeri, dashboard |
| `05-responsive/` | Responsive Design | Mobile-first, hamburger menu, media query, clamp(), tabel scroll |

---

## 💡 Konsep Paling Penting

```css
/* 1. Selalu pakai ini */
*, *::before, *::after { box-sizing: border-box; }

/* 2. Navbar */
nav { display: flex; justify-content: space-between; align-items: center; }

/* 3. Perfect centering */
.box { display: flex; justify-content: center; align-items: center; }

/* 4. Grid responsif otomatis */
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }

/* 5. Mobile-first */
/* CSS default untuk mobile */
@media (min-width: 768px) { /* tambahan untuk tablet ke atas */ }

/* 6. Fluid typography */
h1 { font-size: clamp(1.5rem, 4vw, 2.5rem); }
```

---

## 🔗 Referensi

- [MDN Web Docs](https://developer.mozilla.org)
- [Flexbox Froggy](https://flexboxfroggy.com/) — game belajar Flexbox
- [Grid Garden](https://cssgridgarden.com/) — game belajar Grid
- [CSS Tricks](https://css-tricks.com)
- [W3C Validator](https://validator.w3.org/)

---

## 🚀 Cara Buka

Buka file `.html` langsung di browser, atau pakai **VS Code Live Server** untuk auto-refresh.