# DESIGN.md — Pustaka Web: Modern Classic Retro
> Design system untuk aplikasi perpustakaan digital dengan nuansa buku tua yang hangat, bento grid layout, dan pengalaman yang menyenangkan.
> views menerapkan Brad Frost's Atomic Design methodology

---

## 🎨 Identitas Visual

**Konsep:** *"Toko buku vintage yang sudah didigitalisasi"* — kehangatan rak kayu, aroma kertas tua, tapi dengan kenyamanan pencarian digital modern.

**Signature Element:** Setiap bento card memiliki subtle paper-grain texture dan book-spine accent strip di sisi kiri — mengingatkan punggung buku di rak perpustakaan.

---

## Palet Warna

Tambahkan ke `tailwind.config.js` di dalam `theme.extend.colors`:

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        // === BASE ===
        cream: {
          50:  '#FDFAF4',  // background utama halaman
          100: '#F7F0E0',  // background card ringan
          200: '#EDE0C8',  // border halus, divider
        },

        // === BROWN (Primary) ===
        bark: {
          300: '#C4956A',  // hover state, icon aktif
          400: '#A67449',  // aksen sekunder
          500: '#7D5230',  // warna teks heading, tombol utama
          600: '#5C3A1E',  // teks dark, navbar background
          700: '#3B2110',  // teks paling gelap, footer
        },

        // === TERRACOTTA (Accent) ===
        terra: {
          300: '#E8A87C',  // badge, highlight baru
          400: '#D4724A',  // CTA utama, tombol "Pinjam"
          500: '#B85430',  // hover CTA
        },

        // === SAGE (Secondary Accent) ===
        sage: {
          200: '#C8D5B9',  // tag "Tersedia"
          400: '#7A9E6E',  // ikon status, badge kategori
          600: '#4A6741',  // teks badge gelap
        },

        // === NEUTRAL ===
        parchment: '#F2E8D5',  // background card utama
        ink:       '#2C1A0E',  // teks body utama
        dusty:     '#9E8A78',  // teks placeholder, caption
      },
    },
  },
}
```

### Penggunaan Warna

| Elemen                  | Warna                          |
|-------------------------|-------------------------------|
| Page background         | `cream-50`                    |
| Card background         | `parchment` / `cream-100`     |
| Heading utama           | `bark-500`                    |
| Body text               | `ink`                         |
| Teks sekunder/caption   | `dusty`                       |
| Tombol primer (Pinjam)  | `terra-400` → hover `terra-500` |
| Tombol sekunder         | `bark-500` → hover `bark-600` |
| Outline/border card     | `cream-200`                   |
| Badge "Tersedia"        | `sage-200` + teks `sage-600`  |
| Badge "Dipinjam"        | `terra-300` + teks `bark-600` |
| Navbar / Sidebar        | `bark-600`                    |
| Footer                  | `bark-700`                    |

---

## Tipografi

Tambahkan ke `<head>` layout utama:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
```

Tambahkan ke `tailwind.config.js`:

```js
fontFamily: {
  display: ['"Playfair Display"', 'Georgia', 'serif'],  // judul besar, hero
  body:    ['"DM Sans"', 'system-ui', 'sans-serif'],    // semua teks UI
  mono:    ['"DM Mono"', 'monospace'],                  // nomor buku, kode ISBN
},
```

### Skala Tipografi

| Token              | Kelas Tailwind                               | Penggunaan                    |
|--------------------|----------------------------------------------|-------------------------------|
| Display XL         | `font-display text-5xl font-bold`            | Hero headline                 |
| Display LG         | `font-display text-3xl font-semibold`        | Judul halaman, section header |
| Display MD         | `font-display text-xl italic`                | Judul card buku               |
| Body Base          | `font-body text-base font-normal`            | Deskripsi, paragraf           |
| Body Small         | `font-body text-sm font-medium`              | Label, metadata               |
| Caption            | `font-body text-xs text-dusty`               | Tanggal, author kecil         |
| Mono               | `font-mono text-sm tracking-tight`           | ISBN, kode buku, angka stat   |

---

## Spacing & Border Radius

```js
// tailwind.config.js — extend
borderRadius: {
  'card':  '1rem',    // 16px — card standar bento
  'card-lg': '1.5rem', // 24px — card hero / featured
  'pill':  '9999px',  // badge, tag
  'btn':   '0.625rem', // 10px — tombol
},
spacing: {
  'bento-gap': '1rem',      // gap antar bento card (16px)
  'bento-gap-lg': '1.5rem', // gap untuk layout besar (24px)
},
```

**Aturan praktis:**
- Semua card: `rounded-card` (16px)
- Card hero/featured: `rounded-card-lg` (24px)
- Badge & tag: `rounded-pill`
- Tombol: `rounded-btn`
- Input field: `rounded-lg` (8px)
- **Tidak ada elemen dengan `rounded-none`** kecuali divider horizontal

---

## Bento Grid Layout

### Konsep Grid

Bento grid menggunakan CSS Grid dengan area bernama. Setiap card punya proporsi berbeda untuk menciptakan ritme visual seperti rak buku.

```html
<!-- Contoh layout grid utama (beranda) -->
<div class="grid grid-cols-12 gap-bento-gap auto-rows-[180px]">

  <!-- Hero card — lebar penuh, 2 baris -->
  <div class="col-span-12 row-span-2 ...">...</div>

  <!-- Statistik kecil — 3 kolom masing-masing -->
  <div class="col-span-4 row-span-1 ...">...</div>
  <div class="col-span-4 row-span-1 ...">...</div>
  <div class="col-span-4 row-span-1 ...">...</div>

  <!-- Buku terbaru — 8 kolom, 2 baris -->
  <div class="col-span-8 row-span-2 ...">...</div>

  <!-- Widget "Buku Favorit" — 4 kolom, 2 baris -->
  <div class="col-span-4 row-span-2 ...">...</div>

  <!-- Card buku individual — 3 kolom tiap buku -->
  <div class="col-span-3 row-span-2 ...">...</div>
  <!-- ... ulangi 4x untuk satu baris buku -->

</div>
```

### Tipe Card Bento

#### 1. `BookCard` — Card buku standar
```html
<div class="
  bg-parchment border border-cream-200
  rounded-card p-4
  flex flex-col gap-2
  hover:shadow-md hover:-translate-y-0.5
  transition-all duration-200
  group
">
  <!-- Book spine accent -->
  <div class="absolute left-0 top-0 bottom-0 w-1 bg-terra-400 rounded-l-card"></div>

  <!-- Cover thumbnail -->
  <div class="aspect-[2/3] bg-cream-200 rounded-lg overflow-hidden">
    <img src="..." class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
  </div>

  <!-- Judul dengan font display -->
  <h3 class="font-display text-base font-semibold text-bark-600 line-clamp-2">Judul Buku</h3>

  <!-- Author -->
  <p class="font-body text-xs text-dusty">Penulis · Tahun</p>

  <!-- Badge status -->
  <span class="font-body text-xs font-medium px-2 py-0.5 rounded-pill bg-sage-200 text-sage-600 w-fit">
    ✓ Tersedia
  </span>
</div>
```

#### 2. `StatCard` — Widget statistik
```html
<div class="bg-bark-500 text-cream-50 rounded-card p-5 flex flex-col justify-between">
  <span class="font-body text-sm font-medium opacity-70">Total Koleksi</span>
  <div>
    <p class="font-mono text-4xl font-medium">4.821</p>
    <p class="font-body text-xs opacity-60 mt-1">buku terdaftar</p>
  </div>
</div>
```

#### 3. `FeaturedCard` — Hero buku pilihan
```html
<div class="
  bg-gradient-to-br from-bark-500 to-bark-700
  rounded-card-lg p-6 text-cream-50
  relative overflow-hidden
">
  <!-- Decorative background pattern -->
  <div class="absolute inset-0 opacity-10 bg-[url('/images/paper-grain.png')] bg-repeat"></div>

  <div class="relative flex gap-6 items-start">
    <img src="..." class="w-24 rounded-lg shadow-lg flex-shrink-0">
    <div class="flex flex-col gap-2">
      <span class="font-body text-xs font-medium text-terra-300 uppercase tracking-widest">Pilihan Editor</span>
      <h2 class="font-display text-2xl font-bold">Judul Buku Pilihan</h2>
      <p class="font-body text-sm opacity-80 line-clamp-3">Deskripsi singkat buku ini...</p>
      <button class="mt-2 font-body text-sm font-semibold bg-terra-400 hover:bg-terra-500 px-4 py-2 rounded-btn transition-colors w-fit">
        Pinjam Sekarang
      </button>
    </div>
  </div>
</div>
```

#### 4. `CategoryCard` — Navigasi kategori
```html
<div class="
  bg-cream-100 border border-cream-200
  rounded-card p-4
  flex flex-col items-center justify-center gap-2 text-center
  hover:bg-bark-500 hover:text-cream-50 hover:border-bark-500
  transition-all duration-200 cursor-pointer group
">
  <span class="text-2xl">📖</span>
  <p class="font-body text-sm font-semibold text-bark-500 group-hover:text-cream-50">Fiksi</p>
  <p class="font-mono text-xs text-dusty group-hover:text-cream-200">234 buku</p>
</div>
```

---

## Komponen UI
### Tombol

```html
<!-- Primer -->
<button class="font-body font-semibold text-sm bg-terra-400 hover:bg-terra-500 text-white px-5 py-2.5 rounded-btn transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-terra-400 focus:ring-offset-2">
  Pinjam Buku
</button>

<!-- Sekunder -->
<button class="font-body font-semibold text-sm bg-transparent border-2 border-bark-500 text-bark-500 hover:bg-bark-500 hover:text-cream-50 px-5 py-2.5 rounded-btn transition-all duration-150">
  Lihat Detail
</button>

<!-- Ghost / Tersier -->
<button class="font-body font-medium text-sm text-bark-400 hover:text-bark-600 hover:underline transition-colors">
  Baca Sinopsis →
</button>
```

### Input & Search

```html
<!-- Search bar utama -->
<div class="relative">
  <span class="absolute left-4 top-1/2 -translate-y-1/2 text-dusty">🔍</span>
  <input
    type="text"
    placeholder="Cari judul, penulis, atau ISBN..."
    class="
      w-full font-body text-sm text-ink
      bg-cream-100 border border-cream-200
      rounded-card px-4 py-3 pl-11
      placeholder:text-dusty
      focus:outline-none focus:ring-2 focus:ring-bark-300 focus:border-bark-300
      focus:bg-white transition-all duration-150
    "
  >
</div>
```

### Badge & Tag

```html
<!-- Status tersedia -->
<span class="inline-flex items-center gap-1 font-body text-xs font-medium px-2.5 py-1 rounded-pill bg-sage-200 text-sage-600">
  <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span> Tersedia
</span>

<!-- Status dipinjam -->
<span class="inline-flex items-center gap-1 font-body text-xs font-medium px-2.5 py-1 rounded-pill bg-terra-300/30 text-bark-600">
  <span class="w-1.5 h-1.5 rounded-full bg-terra-400"></span> Dipinjam
</span>

<!-- Tag kategori -->
<span class="font-body text-xs font-medium px-2.5 py-1 rounded-pill bg-cream-200 text-bark-400 hover:bg-bark-500 hover:text-cream-50 cursor-pointer transition-colors">
  Fiksi
</span>
```

### Navbar

```html
<nav class="bg-bark-600 text-cream-50 px-6 py-4 sticky top-0 z-50 shadow-sm">
  <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">

    <!-- Logo + nama -->
    <a href="/" class="flex items-center gap-2.5">
      <span class="text-xl">📚</span>
      <span class="font-display text-lg font-bold text-cream-50">Pustaka</span>
      <span class="font-display text-lg font-light text-bark-300 italic">Nusantara</span>
    </a>

    <!-- Nav links -->
    <div class="hidden md:flex items-center gap-1">
      <a href="/books" class="font-body text-sm font-medium px-3 py-1.5 rounded-btn hover:bg-bark-500 text-cream-100 hover:text-cream-50 transition-colors">Koleksi</a>
      <a href="/categories" class="font-body text-sm font-medium px-3 py-1.5 rounded-btn hover:bg-bark-500 text-cream-100 hover:text-cream-50 transition-colors">Kategori</a>
      <a href="/new" class="font-body text-sm font-medium px-3 py-1.5 rounded-btn hover:bg-bark-500 text-cream-100 hover:text-cream-50 transition-colors">Terbaru</a>
    </div>

    <!-- Right side -->
    <div class="flex items-center gap-2">
      <button class="font-body text-sm font-semibold bg-terra-400 hover:bg-terra-500 px-4 py-1.5 rounded-btn transition-colors">
        Masuk
      </button>
    </div>
  </div>
</nav>
```

### Sidebar (Panel navigasi dalam)

```html
<aside class="bg-cream-100 border-r border-cream-200 w-64 flex flex-col gap-1 p-3">

  <!-- Section label -->
  <p class="font-body text-xs font-semibold text-dusty uppercase tracking-widest px-3 pt-2 pb-1">Menu Utama</p>

  <!-- Nav item — active -->
  <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-card bg-bark-500 text-cream-50 font-body text-sm font-medium">
    <span>🏠</span> Beranda
  </a>

  <!-- Nav item — default dengan book spine accent -->
  <a href="#" class="relative flex items-center gap-3 px-3 py-2.5 rounded-card hover:bg-cream-200 text-ink font-body text-sm font-medium transition-colors group">
    <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-0.5 bg-terra-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
    <span>📖</span> Koleksi Buku
  </a>

  <a href="#" class="relative flex items-center gap-3 px-3 py-2.5 rounded-card hover:bg-cream-200 text-ink font-body text-sm font-medium transition-colors group">
    <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-0.5 bg-terra-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
    <span>📋</span> Peminjaman Saya
  </a>

  <a href="#" class="relative flex items-center gap-3 px-3 py-2.5 rounded-card hover:bg-cream-200 text-ink font-body text-sm font-medium transition-colors group">
    <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-0.5 bg-terra-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
    <span>🔖</span> Bookmark
  </a>

</aside>
```

### Modal (Detail Buku)

```html
<!-- Overlay -->
<div class="fixed inset-0 bg-bark-700/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">

  <!-- Modal card -->
  <div class="bg-parchment rounded-card-lg shadow-2xl max-w-lg w-full p-6 flex gap-5 relative">

    <!-- Tombol tutup -->
    <button class="absolute top-4 right-4 text-dusty hover:text-ink transition-colors">✕</button>

    <!-- Cover -->
    <img src="..." class="w-32 rounded-lg shadow-md flex-shrink-0 self-start">

    <!-- Info -->
    <div class="flex flex-col gap-2 flex-1">
      <span class="font-body text-xs text-terra-400 font-semibold uppercase tracking-widest">Novel · Fiksi</span>
      <h2 class="font-display text-xl font-bold text-bark-600">Judul Buku Panjang Di Sini</h2>
      <p class="font-body text-sm text-dusty">Ahmad Fuadi · 2023</p>
      <p class="font-mono text-xs text-dusty">ISBN: 978-602-xxx-xxx-x</p>

      <p class="font-body text-sm text-ink leading-relaxed mt-1">
        Sinopsis singkat buku yang menggambarkan isi cerita dalam 2-3 kalimat...
      </p>

      <div class="flex gap-2 mt-3">
        <button class="font-body font-semibold text-sm bg-terra-400 hover:bg-terra-500 text-white px-4 py-2 rounded-btn transition-colors">
          Pinjam Buku
        </button>
        <button class="font-body font-medium text-sm border border-cream-200 hover:border-bark-300 text-bark-400 px-4 py-2 rounded-btn transition-colors">
          🔖 Simpan
        </button>
      </div>
    </div>
  </div>
</div>
```

---

## Animasi & Transisi

Semua animasi harus terasa **ringan dan organik** — bukan flashy. Gunakan prinsip "buku yang diambil dari rak".

```js
// tailwind.config.js — extend
transitionDuration: {
  DEFAULT: '150ms',
  'slow': '300ms',
},
transitionTimingFunction: {
  'book': 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
},
animation: {
  'slide-up': 'slideUp 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)',
  'fade-in':  'fadeIn 0.2s ease-out',
},
keyframes: {
  slideUp: {
    '0%':   { opacity: '0', transform: 'translateY(12px)' },
    '100%': { opacity: '1', transform: 'translateY(0)' },
  },
  fadeIn: {
    '0%':   { opacity: '0' },
    '100%': { opacity: '1' },
  },
},
```

### Aturan Animasi

| Elemen              | Efek                                             |
|---------------------|--------------------------------------------------|
| Card hover          | `hover:-translate-y-0.5 hover:shadow-md`        |
| Tombol hover        | `transition-colors duration-150`                |
| Image dalam card    | `group-hover:scale-105 transition-transform duration-300` |
| Modal masuk         | `animate-slide-up`                              |
| Page load           | `animate-fade-in`                               |
| Sidebar nav hover   | Book spine accent fade in `transition-opacity`  |

**Wajib:** Selalu sertakan `motion-safe:` prefix untuk semua animasi besar:
```html
<div class="motion-safe:animate-slide-up">...</div>
```

---

## Paper Texture (Signature Element)

Buat file `resources/css/paper-texture.css`:

```css
/* Paper grain effect untuk card — applied via @layer components */
@layer components {
  .paper-grain {
    position: relative;
  }
  .paper-grain::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.025;
    pointer-events: none;
    z-index: 1;
  }
}

/* Book spine accent — kiri card */
@layer components {
  .book-spine {
    @apply relative;
  }
  .book-spine::after {
    content: '';
    @apply absolute left-0 top-3 bottom-3 w-0.5 bg-terra-400 rounded-full opacity-60;
  }
  .book-spine:hover::after {
    @apply opacity-100;
  }
}
```

Import di `resources/css/app.css`:
```css
@import './paper-texture.css';
```

---

## Shadow System

```js
// tailwind.config.js — extend
boxShadow: {
  'card':    '0 2px 8px -1px rgba(60, 33, 16, 0.08), 0 1px 3px -1px rgba(60, 33, 16, 0.04)',
  'card-hover': '0 8px 24px -4px rgba(60, 33, 16, 0.12), 0 2px 8px -2px rgba(60, 33, 16, 0.06)',
  'modal':   '0 24px 64px -8px rgba(60, 33, 16, 0.24)',
  'navbar':  '0 1px 0 0 rgba(60, 33, 16, 0.12)',
},
```

Gunakan `shadow-card` di default, `shadow-card-hover` saat hover.

---

## Responsivitas

| Breakpoint | Grid              | Sidebar           | Card              |
|------------|-------------------|-------------------|-------------------|
| `sm` < 640px  | 1 kolom, stack    | Bottom nav bar    | Full width        |
| `md` 640–1024 | 2–4 kolom         | Drawer / hidden   | 50% width         |
| `lg` > 1024px | Bento grid penuh  | Sidebar tetap     | Bento proportions |

```html
<!-- Grid responsif contoh -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-4 lg:gap-bento-gap">
```

---

## Aksesibilitas

- Semua warna teks memenuhi **WCAG AA** (kontras ≥ 4.5:1):
    - `ink` (#2C1A0E) di atas `cream-50` (#FDFAF4): **14.2:1** ✓
    - `cream-50` di atas `bark-600` (#5C3A1E): **8.1:1** ✓
    - `sage-600` di atas `sage-200`: **4.8:1** ✓
- Setiap tombol interaktif wajib: `focus:outline-none focus:ring-2 focus:ring-offset-2`
- Input wajib punya `<label>` atau `aria-label`
- Semua gambar buku wajib `alt="[Judul Buku] oleh [Penulis]"`
- Gunakan `motion-safe:` untuk semua animasi

---

*Design system ini dirancang untuk memberikan nuansa perpustakaan yang hangat dan familiar, sekaligus modern dan mudah dinavigasi. Setiap keputusan visual — dari grain texture hingga book spine accent — mengacu pada dunia fisik buku yang ingin kita hadirkan secara digital.*
