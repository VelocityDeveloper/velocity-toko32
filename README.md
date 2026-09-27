Velocity Child Theme Paket Toko Online Toko 32
=================
[toko32.velocitydeveloper.com](https://www.toko32.velocitydeveloper.com/)

Child Theme for the Velocity System WordPress theme.

### Required
Theme Velocity versi 2.7.0 keatas, [Download](https://github.com/VelocityDeveloper/velocity/releases)

### Required Plugins
**VD Store**, [Download](https://github.com/Velocity-Developer/vd-store/releases) — produk `store_product`,
kategori `store_product_cat`, merek `brand`. Sejak 1.1.0 tema tidak lagi memakai plugin Velocity Toko
maupun Kirki.

Integrasi VD Store ada di `inc/vd-store.php`, `css/vd-store.css`, dan template override di folder
`vd-store/` (arsip, kategori, merek, detail produk). Pencarian situs diarahkan ke arsip produk.

| Velocity Toko (≤1.0.x) | VD Store (1.1.0) |
|---|---|
| `[harga]` | `[wp_store_price]` |
| `[beli]` | `[wp_store_add_to_cart]` |
| `[cart]` | `[wp_store_cart]` |
| `[profile]` | ikon ke halaman Profil Saya VD Store (`velocity_toko32_profil()`) |
| `[kontak]` | kontak dari pengaturan VD Store (`velocity_toko32_kontak()`) |
| `[thumbnail]` | `[wp_store_thumbnail]` (label & diskon dari VD Store) |
| `[slider-produk]` | `[wp_store_gallery]` |
| `[detail-produk]` | `[wp_store_product_info]` |
| `[love]` | `[wp_store_add_to_wishlist]` |
| `[beli-lain]` | `velocity_toko32_beli_lain()` |
| `[share]` | `[velocity-sharepost]` (Velocity Addons) |
| filter kategori | `[wp_store_filters]` |

### Beranda
Template **Home Template** (`page-home.php`): header logo + kotak cari + ikon keranjang/profil, menu abu, sidebar KIRI,
slider di kolom konten, judul "nama situs-tagline", 6 produk 3 kolom (tombol Detail + keranjang) berpaginasi, lalu artikel
gaya baris. Arsip kategori/merek: filter VD Store di kiri.

### Widget
Shortcode untuk widget Teks (susunan demo, dibaca installer lewat `velocity_tema_widget_sidebar()` / `velocity_tema_widget_footer()`):

- Sidebar (kiri): `[toko32_kategori]`, `[toko32_best_seller]` (label Best Seller VD Store, cadangan: terlaris),
  `[toko32_info_terbaru]`, `[toko32_testimoni jumlah="5"]` (ulasan produk VD Store),
  `[toko32_sosmed facebook="…" instagram="…" twitter="…" youtube="…"]`, `[toko32_banner]` (tanpa judul)
- Footer (4 kolom): `[toko32_ekspedisi]`, `[toko32_kontak]`, `[toko32_bank]`, `[toko32_produk_terbaru]`
- Lainnya: `[velocity-statistics]` (Velocity Addons), `[kontak-inline style="false"]`

### Halaman
Halaman **Konfirmasi Pembayaran** = `[store_tracking]` (input nomor pesanan VD Store: tagihan, rekening, unggah bukti
transfer). Override tipis `vd-store/pages/tracking.php` membuat pencarian tetap di halaman tempat form dipasang.

### Customizer
Appearance > Customize > **Velocity Toko 32**: Warna (utama & sekunder; bawaan #9e26c6), Slider Home (5 slot gambar),
Banner Sidebar (gambar + tautan untuk widget `[toko32_banner]`; kosong = widget disembunyikan), Velocity Home News
(judul & kategori artikel beranda). Latar website: pengaturan Background tema induk. Logo: Site Identity.
Halaman beranda memakai template **Home Template**, halaman pricelist template **Velocity Toko Pricelist**.
Halaman Katalog & Profil Saya VD Store selalu tanpa sidebar.

### Usage
Simply download the zip and upload the zip (velocity-toko32.zip) under your WordPress dashboard at Appearance > Themes. Or extract and upload via FTP at wp-content/themes/.
