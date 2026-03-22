# 02 — CSS Dasar

**Topik:** Cascade, Specificity, Display, Positioning, Pseudo-class & Pseudo-element, Transisi  
**File:** `index.html` + `style.css`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Konsep Penting

### Cascade — Aturan Mana yang Menang?

Ketika ada dua aturan CSS yang menyasar elemen yang sama, pemenangnya ditentukan oleh:

1. **Specificity** (skor selector)
2. **Order** — jika skor sama, yang lebih bawah di file menang
3. **`!important`** — paksa menang (hindari!)

### Specificity — Cara Hitung Skor

```
Inline style      → 1,0,0,0  (tertinggi)
#id               → 0,1,0,0
.class :hover []  → 0,0,1,0
tag ::before      → 0,0,0,1  (terendah)
* + > ~           → 0,0,0,0
```

```css
p { color: gray; }              /* 0,0,0,1 */
.teks { color: blue; }          /* 0,0,1,0 → menang */
#paragraf { color: green; }     /* 0,1,0,0 → menang */
```

**Tips:** Hindari ID selector dan `!important` — susah di-override. Pakai class saja.

---

### Display

| Nilai | Perilaku | Contoh Elemen |
|---|---|---|
| `block` | Ambil 1 baris penuh, bisa atur width/height | `div`, `p`, `h1` |
| `inline` | Sebesar konten, mengalir dalam teks, **tidak** bisa atur width/height | `span`, `a`, `strong` |
| `inline-block` | Mengalir seperti inline, **bisa** atur width/height | — |
| `none` | Hilang total dari layout | — |
| `flex` | Flexbox container | — |
| `grid` | Grid container | — |

---

### Positioning

| Nilai | Perilaku |
|---|---|
| `static` | Default — ikuti aliran normal |
| `relative` | Geser dari posisi normal, ruang asli tetap ada |
| `absolute` | Keluar aliran, posisi relatif ke parent positioned |
| `fixed` | Menempel di viewport, tidak bergerak saat scroll |
| `sticky` | Normal + menempel saat mencapai threshold |

```css
/* Pola paling umum: absolute di dalam relative */
.parent { position: relative; }
.badge  { position: absolute; top: 0; right: 0; }
```

---

### Pseudo-class vs Pseudo-element

```css
/* Pseudo-class — kondisi/state (satu titik dua) */
a:hover     { color: blue; }       /* saat mouse di atas */
input:focus { border: blue; }      /* saat input aktif */
li:nth-child(even) { background: gray; } /* baris genap */

/* Pseudo-element — bagian dari elemen (dua titik dua) */
p::first-letter { font-size: 2em; }  /* huruf pertama */
.card::before { content: '★'; }      /* konten sebelum elemen */
::selection { background: blue; }    /* teks yang diseleksi */
```

---

### Transisi

```css
/* Format: property | durasi | timing | delay */
transition: background 0.3s ease;
transition: all 0.2s ease-in-out;

/* Untuk multiple property */
transition: background 0.3s ease, transform 0.2s ease;
```

```css
/* Animasi dengan @keyframes */
@keyframes masuk {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

.elemen {
  animation: masuk 0.5s ease forwards;
}
```

---

## 🗂️ Isi File

### `index.html`
6 section dengan demo visual interaktif semua konsep CSS dasar.

### `style.css`
- CSS Variables (`:root`)
- Reset & base styles
- Demo cascade (class menang vs tag selector)
- Tabel specificity dengan skor visual
- Demo display: block, inline, inline-block, none
- Demo positioning: relative, absolute, fixed, sticky
- Pseudo-class: `:hover`, `:nth-child`, `:last-child`
- Pseudo-element: `::before`, `::after`, `::first-letter`, `::selection`
- Transition & `@keyframes` animation

---

## 🔗 Referensi

- [MDN CSS Cascade](https://developer.mozilla.org/en-US/docs/Web/CSS/Cascade)
- [MDN Specificity](https://developer.mozilla.org/en-US/docs/Web/CSS/Specificity)
- [CSS Specificity Calculator](https://specificity.keegan.st/)
- [MDN Positioning](https://developer.mozilla.org/en-US/docs/Web/CSS/position)

---

## 🚀 Cara Buka

Buka `index.html` di browser. Hover tombol di Section 6 untuk melihat demo transisi.