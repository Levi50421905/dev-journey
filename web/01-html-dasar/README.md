# 01 — HTML Dasar

**Topik:** Struktur HTML, Elemen Semantik, Form, Tabel, Media  
**File:** `index.html` + `style.css`  
**Author:** Muhammad Alfarezzi Fallevi · 4IA17 · 50421905

---

## 🧠 Filosofi

> Jangan hapal kode. Pahami **kenapa** kode itu ada.

HTML punya ratusan elemen — mustahil dihafal semua. Yang perlu dipahami adalah **logika di baliknya**. Kalau sudah paham logikanya, kamu bisa tebak elemen apa yang diperlukan bahkan sebelum Googling.

---

## 📄 Isi File

### `index.html`
Semua elemen penting dengan komentar penjelasan di setiap baris:

| Section | Isi |
|---|---|
| Header & Nav | `<header>`, `<nav>`, `<ul>` untuk navigasi |
| Elemen Teks | `<p>`, `<strong>`, `<em>`, `<code>`, `<blockquote>`, HTML entities |
| List | `<ul>`, `<ol>`, `<dl>`, nested list |
| Tabel | `<table>`, `<thead>`, `<tbody>`, `<tfoot>`, `<caption>` |
| Form | `<form>`, `<fieldset>`, semua tipe input, `<select>`, `<textarea>` |
| Media | `<img>` dengan `alt`, berbagai tipe `<a>` (eksternal, internal, email, tel) |
| Aside & Footer | `<aside>`, `<footer>` |

### `style.css`
CSS dasar dengan penjelasan kenapa setiap properti dipakai:

| Section | Isi |
|---|---|
| CSS Variables | `--nama-variabel` dan `var()` |
| Reset & Base | `box-sizing`, font, line-height |
| Selector | tag, class, id, descendant, child, pseudo-class, pseudo-element |
| Layout | `display: grid` untuk layout halaman |
| Tabel | `border-collapse`, `nth-child` |
| Form | `:focus`, `::placeholder`, transisi |
| Responsive | `@media`, breakpoint 768px & 1024px |

---

## 🌐 HTML — Konsep Penting

### Kenapa Elemen Semantik?

```html
<!-- ❌ Tidak semantik — browser tidak tahu ini apa -->
<div class="header">
  <div class="nav">...</div>
</div>

<!-- ✅ Semantik — browser, screen reader, Google paham -->
<header>
  <nav>...</nav>
</header>
```

### Hierarki Heading

```
h1 → Judul halaman (HANYA 1 per halaman)
  h2 → Bagian utama
    h3 → Sub-bagian
      h4 → Sub-sub-bagian (jarang)

❌ JANGAN skip level: h1 → h3 (salah!)
✅ Ikuti urutan: h1 → h2 → h3
```

### `<div>` dan `<span>` — Kapan Dipakai?

```
Gunakan <div> dan <span> HANYA jika tidak ada elemen
semantik yang sesuai — biasanya hanya untuk styling.

Sebelum pakai <div>, tanya dulu:
→ Apakah ini header? → pakai <header>
→ Apakah ini navigasi? → pakai <nav>
→ Apakah ini konten utama? → pakai <main>
→ Apakah ini artikel? → pakai <article>
→ Apakah ini bagian bertema? → pakai <section>
→ Apakah ini konten sampingan? → pakai <aside>
→ Apakah ini kaki halaman? → pakai <footer>
→ Tidak ada yang cocok? → baru pakai <div>
```

### `<strong>` vs `<b>`, `<em>` vs `<i>`

| Tag | Makna Semantik | Tampilan |
|---|---|---|
| `<strong>` | Konten **penting** — screen reader menekankan | Bold |
| `<b>` | Hanya visual bold, tanpa makna khusus | Bold |
| `<em>` | Konten yang **ditekankan** dalam kalimat | Italic |
| `<i>` | Visual italic — judul buku, istilah teknis | Italic |

---

## 🎨 CSS — Konsep Penting

### Box Model

```
Setiap elemen HTML = kotak dengan 4 lapisan:

┌─────────── margin ──────────────┐
│  ┌──────── border ─────────┐    │
│  │  ┌───── padding ──────┐ │    │
│  │  │     CONTENT        │ │    │
│  │  └────────────────────┘ │    │
│  └────────────────────────┘    │
└────────────────────────────────┘

margin  → jarak ke elemen LAIN (transparan)
border  → garis tepi
padding → jarak konten ke border (di dalam)
content → teks, gambar, elemen anak
```

**Selalu pakai `box-sizing: border-box`:**
```css
/* width yang kamu set = total lebar (padding sudah termasuk) */
*, *::before, *::after { box-sizing: border-box; }
```

### Satuan CSS

| Satuan | Relatif ke | Kapan Pakai |
|---|---|---|
| `px` | — (absolute) | Border, shadow, nilai kecil yang harus exact |
| `rem` | Font-size `<html>` | Font-size, spacing utama ✅ |
| `em` | Font-size parent | Padding/margin relatif terhadap teks |
| `%` | Parent element | Lebar layout fleksibel |
| `vw/vh` | Viewport | Full-screen section, hero |

---

## ❗ Kesalahan Umum

| Kesalahan | Cara Benar |
|---|---|
| Lupa `alt` pada `<img>` | Selalu isi — walau `alt=""` untuk dekoratif |
| `<br>` untuk spasi antar section | Pakai `margin` di CSS |
| `<table>` untuk layout | Pakai Flexbox atau Grid |
| `<b>` dan `<i>` | Pakai `<strong>` dan `<em>` |
| Lebih dari satu `<h1>` | Hanya 1 `<h1>` per halaman |
| Skip heading (h1 → h3) | Ikuti hierarki: h1 → h2 → h3 |
| `placeholder` sebagai pengganti `label` | Selalu pakai `<label>` |

---

## 🔗 Referensi

- [MDN HTML Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element)
- [web.dev — Learn HTML](https://web.dev/learn/html)
- [W3C Validator](https://validator.w3.org/)

---

## 🚀 Cara Buka

Buka `index.html` langsung di browser, atau pakai **VS Code Live Server**.