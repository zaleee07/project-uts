# Panduan Wawancara Kepemilikan Kode

> **Proyek:** ZENITH Coffee & Roastery
> **Referensi:** Slide 24 dan Slide 27, Web Programming 2

Panduan ini merangkum cara menjelaskan fitur yang benar-benar ada di aplikasi. Untuk demonstrasi, jalankan aplikasi lokal dan gunakan akun demo yang dibuat oleh seeder.

## 1. Mengapa penjualan memiliki tabel detail?

Satu transaksi POS dapat berisi beberapa menu atau produk. Tabel `sales` menyimpan data header seperti nomor transaksi, pengguna, status, dan waktu transaksi. Tabel `sale_items` menyimpan produk, jumlah, harga saat transaksi, dan subtotal setiap baris. Relasi `Sale::items()` adalah `hasMany`, sedangkan setiap detail terhubung kembali ke satu penjualan.

**Rujukan:** [Sale.php](./app/Models/Sale.php), [SaleItem.php](./app/Models/SaleItem.php), [migration sale_items](./database/migrations/2024_01_01_000008_create_sale_items_table.php).

## 2. Bagaimana aplikasi mencegah stok menjadi negatif saat penjualan?

Pada `SaleController::store`, aplikasi membaca produk di dalam transaksi database, memeriksa apakah stok cukup, dan menolak transaksi dengan `ValidationException` jika jumlah yang diminta melebihi stok. Stok baru dikurangi setelah pemeriksaan berhasil. Jika salah satu item gagal, `DB::transaction()` membatalkan seluruh perubahan penjualan tersebut.

**Rujukan:** [SaleController.php](./app/Http/Controllers/SaleController.php), [SaleTransactionTest.php](./tests/Feature/SaleTransactionTest.php).

## 3. Mengapa harga dan total dihitung di server?

Harga satuan penjualan diambil dari `selling_price` produk di database. Subtotal dan total dihitung dari harga tersebut dan kuantitas item, bukan dari total yang dikirim browser. Dengan demikian, perubahan nilai pada form klien tidak menjadi sumber harga transaksi.

**Rujukan:** [SaleController.php](./app/Http/Controllers/SaleController.php).

## 4. Bagaimana pembelian mengubah stok?

`PurchaseController::store` menyimpan transaksi dan itemnya di dalam `DB::transaction()`. Setiap item menambah stok produk dan memperbarui harga beli terakhir. Total pembelian dihitung dari item di server. Jika pembelian dibatalkan oleh Owner/Admin, sistem memeriksa stok sebelum mengurangi kembali stok yang sebelumnya ditambahkan.

**Rujukan:** [PurchaseController.php](./app/Http/Controllers/PurchaseController.php), [PurchaseTransactionTest.php](./tests/Feature/PurchaseTransactionTest.php).

## 5. Bagaimana akses dibedakan menurut peran?

Halaman yang memerlukan login berada di grup route `auth`. Grup `role:admin` melindungi pengelolaan produk, kategori, supplier, pengguna, serta pembatalan transaksi; Owner memiliki akses administratif. Route pembelian hanya untuk `admin` dan `staff`. Pelanggan dapat membuat pesanan dan riwayat penjualan difilter agar hanya menampilkan pesanannya sendiri.

Menu yang disembunyikan di Blade bukan satu-satunya perlindungan: middleware memeriksa izin pada request server. Pengujian fitur memverifikasi bahwa Staff dan Pelanggan ditolak saat membuka beberapa route administratif.

**Rujukan:** [web.php](./routes/web.php), [RoleMiddleware.php](./app/Http/Middleware/RoleMiddleware.php), [RoleAuthorizationTest.php](./tests/Feature/RoleAuthorizationTest.php).

## 6. Apa fungsi `lockForUpdate()`?

Saat menyimpan pembelian atau penjualan, controller meminta penguncian baris produk di dalam transaksi database sebelum mengubah stok. Pada database yang mendukung row-level locking seperti MySQL/InnoDB, mekanisme ini membantu mencegah dua transaksi bersamaan mengubah stok berdasarkan nilai lama yang sama. Pemeriksaan jumlah stok tetap dilakukan di server.

**Rujukan:** [SaleController.php](./app/Http/Controllers/SaleController.php), [PurchaseController.php](./app/Http/Controllers/PurchaseController.php).

## 7. Bagaimana dashboard pelanggan berbeda dari dashboard internal?

`DashboardController` mengarahkan Pelanggan ke tampilan katalog dan ringkasan pesanan miliknya. Owner dan Staff melihat dashboard internal dengan ringkasan produk, transaksi, nilai stok, peringatan stok rendah, dan transaksi terbaru. Produk stok rendah dicari dengan kondisi `stock <= minimum_stock`.

**Rujukan:** [DashboardController.php](./app/Http/Controllers/DashboardController.php), [Product.php](./app/Models/Product.php).

## 8. Bagaimana cara menunjukkan aplikasi saat demo?

1. Jalankan migrasi dan seeder pada database lokal.
2. Masuk sebagai `owner@example.com` untuk melihat dashboard internal dan menu pengelolaan.
3. Masuk sebagai `staff@example.com` untuk mencoba alur operasional.
4. Masuk sebagai `pelanggan@example.com` untuk melihat katalog, membuat pesanan, dan membuka riwayat pesanan.
5. Semua akun tersebut dibuat dengan kata sandi demo `password123`.
6. Tunjukkan bahwa stok berubah setelah transaksi dan bahwa akun dengan peran berbeda mendapat akses sesuai izin.

Jangan gunakan akun atau kata sandi demo pada lingkungan publik. Lihat [README.md](./README.md) untuk instruksi setup dan [RoleAuthorizationTest.php](./tests/Feature/RoleAuthorizationTest.php) untuk contoh pengujian izin.
