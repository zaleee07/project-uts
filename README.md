# ☕ ZENITH Coffee & Roastery

Sistem **Point of Sale (POS), penjualan, dan manajemen stok** untuk ZENITH Coffee & Roastery. Aplikasi ini menghubungkan pemesanan pelanggan, transaksi kasir, pasokan dari supplier, dan pemantauan stok dalam satu aplikasi web.

> **Mata kuliah:** Web Programming 2 · **Proyek:** Ujian Tengah Semester (UTS)

## Tentang aplikasi

ZENITH Coffee & Roastery memiliki tampilan bertema kopi dengan kombinasi warna navy, amber, dan emerald. Aplikasi menyediakan dashboard dan navigasi sesuai peran pengguna:

- **Owner:** memantau ringkasan bisnis dan mengelola data operasional.
- **Staff / Barista:** melayani transaksi POS dan mencatat pasokan produk.
- **Pelanggan:** melihat katalog yang tersedia, membuat pesanan, dan melihat riwayat pesanannya sendiri.

## Fitur utama

- Login, logout, dan akses aplikasi berdasarkan peran pengguna.
- Dashboard internal berisi ringkasan penjualan, pembelian, nilai stok, stok menipis, serta transaksi terbaru.
- Portal pelanggan berisi katalog produk yang tersedia, ringkasan pesanan, dan riwayat pesanan pribadi.
- Pengelolaan menu/produk, kategori, supplier, dan akun pengguna.
- Transaksi pembelian/pasokan yang menambahkan stok.
- Transaksi penjualan POS yang memeriksa ketersediaan stok dan mengurangi stok.
- Perhitungan harga dan total transaksi di server.
- Pembatalan transaksi oleh admin dengan penyesuaian stok.
- Pencarian, filter status/tanggal, pagination, dan halaman detail transaksi.
- Pengujian fitur autentikasi, otorisasi role, produk, pembelian, dan penjualan.

## Screenshot tampilan aplikasi

Berikut screenshot halaman aplikasi pada resolusi desktop. Screenshot diambil dari aplikasi yang berjalan menggunakan data demo, bukan data pengguna.

<details>
<summary>Login</summary>

<img src="screenshots/login.png" width="800" alt="Halaman login ZENITH Coffee & Roastery">

</details>

<details>
<summary>Dashboard Owner, Staff, dan Pelanggan</summary>

**Dashboard Owner**

<img src="screenshots/dashboard-owner.png" width="800" alt="Dashboard Owner ZENITH Coffee & Roastery">

**Dashboard Staff**

<img src="screenshots/dashboard-staff.png" width="800" alt="Dashboard Staff ZENITH Coffee & Roastery">

**Dashboard Pelanggan**

<img src="screenshots/dashboard-customer.png" width="800" alt="Dashboard Pelanggan ZENITH Coffee & Roastery">

</details>

<details>
<summary>Menu dan produk</summary>

**Daftar produk**

<img src="screenshots/products-index.png" width="800" alt="Daftar menu dan produk">

**Tambah produk**

<img src="screenshots/products-create.png" width="800" alt="Form tambah produk">

**Detail produk**

<img src="screenshots/products-show.png" width="800" alt="Detail produk">

**Ubah produk**

<img src="screenshots/products-edit.png" width="800" alt="Form ubah produk">

</details>

<details>
<summary>Kategori menu</summary>

**Daftar kategori**

<img src="screenshots/categories-index.png" width="800" alt="Daftar kategori menu">

**Tambah kategori**

<img src="screenshots/categories-create.png" width="800" alt="Form tambah kategori">

**Ubah kategori**

<img src="screenshots/categories-edit.png" width="800" alt="Form ubah kategori">

</details>

<details>
<summary>Supplier</summary>

**Daftar supplier**

<img src="screenshots/suppliers-index.png" width="800" alt="Daftar supplier">

**Tambah supplier**

<img src="screenshots/suppliers-create.png" width="800" alt="Form tambah supplier">

**Ubah supplier**

<img src="screenshots/suppliers-edit.png" width="800" alt="Form ubah supplier">

</details>

<details>
<summary>Pasokan bahan — Owner dan Staff</summary>

**Daftar pasokan — Owner**

<img src="screenshots/purchases-index-owner.png" width="800" alt="Daftar pasokan bahan untuk Owner">

**Catat pasokan — Owner**

<img src="screenshots/purchases-create-owner.png" width="800" alt="Form catat pasokan untuk Owner">

**Detail pasokan — Owner**

<img src="screenshots/purchases-show-owner.png" width="800" alt="Detail pasokan untuk Owner">

**Daftar pasokan — Staff**

<img src="screenshots/purchases-index-staff.png" width="800" alt="Daftar pasokan bahan untuk Staff">

**Catat pasokan — Staff**

<img src="screenshots/purchases-create-staff.png" width="800" alt="Form catat pasokan untuk Staff">

**Detail pasokan — Staff**

<img src="screenshots/purchases-show-staff.png" width="800" alt="Detail pasokan untuk Staff">

</details>

<details>
<summary>Penjualan POS dan pesanan pelanggan</summary>

**Daftar transaksi — Owner**

<img src="screenshots/sales-index-owner.png" width="800" alt="Daftar transaksi penjualan untuk Owner">

**Kasir POS — Owner**

<img src="screenshots/sales-create-owner.png" width="800" alt="Form kasir POS untuk Owner">

**Detail transaksi — Owner**

<img src="screenshots/sales-show-owner.png" width="800" alt="Detail transaksi penjualan untuk Owner">

**Daftar transaksi — Staff**

<img src="screenshots/sales-index-staff.png" width="800" alt="Daftar transaksi penjualan untuk Staff">

**Kasir POS — Staff**

<img src="screenshots/sales-create-staff.png" width="800" alt="Form kasir POS untuk Staff">

**Detail transaksi — Staff**

<img src="screenshots/sales-show-staff.png" width="800" alt="Detail transaksi penjualan untuk Staff">

**Riwayat pesanan — Pelanggan**

<img src="screenshots/sales-index-customer.png" width="800" alt="Riwayat pesanan pelanggan">

**Form pemesanan — Pelanggan**

<img src="screenshots/sales-create-customer.png" width="800" alt="Form pemesanan pelanggan">

**Detail pesanan — Pelanggan**

<img src="screenshots/sales-show-customer.png" width="800" alt="Detail pesanan pelanggan">

</details>

<details>
<summary>Pengelolaan akun pengguna — Owner</summary>

**Daftar pengguna**

<img src="screenshots/users-index.png" width="800" alt="Daftar akun pengguna">

**Tambah pengguna**

<img src="screenshots/users-create.png" width="800" alt="Form tambah pengguna">

**Ubah pengguna**

<img src="screenshots/users-edit.png" width="800" alt="Form ubah pengguna">

</details>

## Teknologi

- PHP 8.2+
- Laravel 11
- Blade
- Tailwind CSS dan Alpine.js melalui CDN
- MySQL
- PHPUnit

> Tailwind CSS dan Alpine.js dimuat dari CDN, sehingga koneksi internet diperlukan agar seluruh tampilan dan interaksi frontend termuat dengan baik.

## Menjalankan secara lokal

### 1. Clone repository

```powershell
git clone https://github.com/zaleee07/project-uts.git
cd project-uts
```

### 2. Instal dependensi dan siapkan environment

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Jika file `.env` sudah ada, jangan menimpanya dengan perintah `Copy-Item`; cukup jalankan `php artisan key:generate` bila diperlukan.

### 3. Siapkan database

Buat database MySQL bernama `inventory_sales_db`, lalu sesuaikan nilai koneksi database di file `.env` bila konfigurasi lokal berbeda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_sales_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat tabel dan data demo

```powershell
php artisan migrate --seed
```

Seeder menyediakan akun demo serta data contoh untuk mencoba aplikasi. Gunakan database lokal kosong saat pertama kali menjalankan perintah ini.

### 5. Jalankan aplikasi

```powershell
php artisan serve
```

Buka <http://127.0.0.1:8000> di browser.

## Akun demo

Semua akun demo yang dibuat oleh seeder menggunakan kata sandi `password123`.

| Peran | Email |
| --- | --- |
| Owner | `owner@example.com` |
| Staff / Barista | `staff@example.com` |
| Pelanggan | `pelanggan@example.com` |

**Akun ini hanya untuk pengembangan dan demonstrasi lokal. Ganti atau hapus kredensial demo sebelum aplikasi digunakan di lingkungan publik.**

## Menjalankan pengujian

```powershell
php artisan test
```

Konfigurasi PHPUnit menggunakan SQLite in-memory untuk pengujian, sehingga data pengujian terpisah dari database lokal.

## Dokumen pendukung

- [Panduan dokumentasi Slide 26 dan 27](./SLIDE_26_DAN_27_DOCUMENTATION.md)
- [Panduan Code Ownership Interview](./INTERVIEW_DEFENSE_GUIDE.md)
