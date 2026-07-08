# Sistem Product Comparison & Spesifikasi

Dokumentasi cara kerja section **Spesifikasi** dan **Comparison (compare)** di halaman
single product.

Section compare memungkinkan pengunjung membandingkan beberapa produk berdampingan.
Setiap kolom punya dropdown untuk memilih produk; tabel di bawahnya menampilkan
spesifikasi tiap produk. Ganti produk di dropdown → tabel diperbarui via AJAX tanpa reload.

---

## Konsep Utama: Satu Sumber Kebenaran

Baris apa yang muncul di **Spesifikasi** dan **Comparison** ditentukan oleh **satu field
tunggal** di Global: **`spesification_info`** (tipe *checkboxes*).

- **Key** setiap opsi = **handle field produk** (mis. `power`, `torque`).
- **Label** setiap opsi = teks yang ditampilkan (mis. `Power`, `Torque`).
- **Centang** = baris itu ditampilkan. **Urutan** mengikuti daftar options.
- **Nilai** diambil otomatis dari field produk dengan handle = key.
- **Key tanpa field produk** (mis. `tes`) otomatis **diabaikan** — tidak ada datanya.

Lokasi: **Globals → Product Label Information → tab "Comparison & Spesification" →
"Spesification Info"**. Untuk mengubah key/label/urutan, edit **Options** pada field itu.

---

## Daftar File

| File | Peran |
|------|-------|
| `resources/views/products/show.blade.php` | Markup section Spesifikasi & Comparison + menyiapkan baris dari `spesification_info` |
| `routes/web.php` | Endpoint AJAX `GET /api/products/{id}/comparison` → data produk sebagai JSON |
| `resources/js/comparison.js` | Front-end: fetch data, isi tabel, hide baris kosong, transisi gambar |
| `resources/css/project.css` | Styling dropdown (tablet/desktop) + skeleton loading gambar |
| `resources/blueprints/globals/product_label_information.yaml` | Field `spesification_info` (sumber key + label) |
| `resources/blueprints/collections/products/product.yaml` | Field spesifikasi produk + grid `product_specifications` (Additional) |

---

## Tiga Sumber Baris

### 1. Baris Model — selalu tampil (paling atas, hanya di Comparison)
Diambil dari `sku` produk (fallback `title`). Tidak bisa dihilangkan. Font lebih besar
(`text-2xl`, font display).

### 2. Baris dari `spesification_info` — Spesifikasi & Comparison
Baris yang dicentang di `spesification_info` DAN punya field produk yang cocok.
Ini muncul di **kedua** section. Label & urutan dari options; nilai dari field produk.

### 3. Additional (`product_specifications`) — HANYA Spesifikasi
Grid `product_specifications` di produk (kolom `heading` + `short_description`) hanya
tampil di **section Spesifikasi**. **TIDAK** ikut di Comparison.

---

## Alur Comparison (AJAX)

```
1. Halaman render (Blade)
   - Baca spesification_info (options dari blueprint + key tercentang dari value)
   - Bangun $compareRows: Model + baris yang key-nya cocok field produk
   - Render kerangka tabel (dropdown, gambar, baris kosong ber-data-field)
        │
2. JS (comparison.js) untuk tiap kolom
   - Baca produk terpilih → fetch GET /api/products/{id}/comparison
        │
3. Endpoint (routes/web.php) balas JSON
   { id, title, model, image, rows:[ {field,label,value}, ... ] }
        │
4. JS isi tabel
   - Cocokkan value ke cell berdasarkan data-field (bukan index)
   - Gambar di-preload lalu fade-in (skeleton saat loading)
   - Baris kosong di SEMUA kolom → disembunyikan
   - Cell kosong (kolom lain terisi) → placeholder (Empty Placeholder Data)
```

Saat ganti dropdown, hanya langkah 2–4 yang diulang untuk kolom tsb.

### Contoh respons endpoint
```json
{
  "id": "product-fd375dt",
  "title": "FD375DT 6X4",
  "model": "FD375DT (6X4)",
  "image": "/assets/fd375dt-(1).png",
  "rows": [
    { "field": "model",              "label": "Model",              "value": "FD375DT (6X4)" },
    { "field": "power",              "label": "Power",              "value": "430 HP" },
    { "field": "torque",             "label": "Torque",             "value": "2.060 Nm" },
    { "field": "standard_emission",  "label": "Standard Emission",  "value": "Euro 5" },
    { "field": "gcw",                "label": "GCW",                "value": "" },
    { "field": "gvw",                "label": "GVW",                "value": "50.000 Kg" },
    { "field": "fuel_tank_capacity", "label": "Fuel Tank Capacity", "value": "400 L" }
  ]
}
```

---

## Cara Membaca `spesification_info` (Teknis)

`checkboxes` menyimpan **key tercentang** di content, sedangkan **options (key→label)**
ada di **blueprint**. Jadi runtime menggabungkan keduanya:

```php
// Options (key => label) dari blueprint
$options = collect($global->blueprint()->field('spesification_info')->config()['options'])
    ->mapWithKeys(fn ($opt, $k) =>
        is_array($opt) && isset($opt['key'])
            ? [$opt['key'] => $opt['value'] ?? $opt['key']]
            : [$k => $opt]
    );

// Key tercentang dari value
$selected = collect($global->value('spesification_info'))->filter(fn ($v) => is_string($v));

// Baris final: dicentang DAN punya field produk
$rows = $options->filter(fn ($label, $key) =>
    $selected->contains($key) && $productFieldHandles->contains($key)
);
```

Logika ini identik di **blade** (untuk render) dan **route** (untuk JSON), jadi tetap sinkron.

---

## Cara Menambah / Mengubah

| Kebutuhan | Langkah |
|-----------|---------|
| Tambah/kurangi baris di Spesifikasi & Compare | Globals → Product Label Information → **Spesification Info** → centang/hapus centang |
| Ubah label baris | Edit kolom **Label** pada Options `spesification_info` |
| Ubah urutan baris | Ubah urutan Options `spesification_info` (drag) |
| Tambah baris khusus produk (tanpa compare) | Isi grid **Product Specifications (Optional)** di produk |
| Ubah placeholder saat data kosong | Globals → **Empty Placeholder Data** |
| Ubah jumlah kolom compare | Ubah `$compareColumns` di `show.blade.php` |
| Tambah field spesifikasi produk baru | 1) Tambah field di blueprint produk. 2) Tambah option baru di `spesification_info` dengan **Key = handle field** tsb. |

---

## Catatan Teknis

- **Model** tidak bisa dihilangkan (by design) — identitas produk di tabel compare.
- **Urutan baris**: Model → baris `spesification_info` (sesuai urutan options).
- **Key = handle field produk.** Kalau key tidak punya field produk, baris diabaikan
  (tidak ada data yang bisa diambil).
- **Additional (`product_specifications`)** hanya untuk section Spesifikasi, tidak pernah
  masuk Comparison.
- **Baris kosong**: kalau suatu baris kosong di **semua** kolom → disembunyikan; kalau
  kosong di sebagian kolom → tampil placeholder (`Empty Placeholder Data`, mis. `N/A`).
- **Styling dropdown** (panel terbuka) hanya di **tablet/desktop** (`min-width: 768px`) &
  browser yang mendukung `appearance: base-select` (Chrome/Edge terbaru). Di mobile /
  browser lain → dropdown native.
- **Gambar**: di-preload lalu fade-in; skeleton shimmer saat loading; gagal → `src`
  dikosongkan (tanpa ikon broken).
