# Panduan Wawancara Kepemilikan Kode (Code Ownership Defense Guide)
> **Referensi:** Slide 24 & Slide 27 (Langkah 9) — Web Programming 2 (UTS Integrated Project)

Dokumen ini disusun untuk mempersiapkan mahasiswa menghadapi sesi demo dan wawancara (*code defense*) di depan dosen penguji. Dosen dapat memilih file atau fungsi secara acak dan meminta penjelasan logika serta modifikasi kode secara langsung.

---

### Pertanyaan 1: Mengapa `Sale` memiliki relasi `hasMany` ke `SaleItem`?
* **File Rujukan:** [`app/Models/Sale.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Models/Sale.php) & [`database/migrations/2024_01_01_000008_create_sale_items_table.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/database/migrations/2024_01_01_000008_create_sale_items_table.php)
* **Jawaban Ideal Mahasiswa:**
  > "Dalam skenario bisnis kasir/ritel, satu transaksi penjualan (header) dapat memuat lebih dari satu jenis barang/produk dengan kuantitas dan harga satuan yang berbeda-beda. Ini mengikuti pola perancangan database **Header-Detail (Master-Detail)**.
  > Tabel `sales` bertindak sebagai header untuk menyimpan metadata transaksi tunggal (seperti nomor faktur `sale_number`, ID kasir, status, dan tanggal), sedangkan tabel `sale_items` bertindak sebagai entitas detail yang menyimpan masing-masing item barang. Oleh karena itu, satu objek `Sale` memiliki banyak (`hasMany`) objek `SaleItem`. Foreign key `sale_id` berada di tabel anak (`sale_items`) untuk menunjuk ke faktur induknya."

---

### Pertanyaan 2: Di mana sistem memastikan stok tidak menjadi negatif?
* **File Rujukan:** [`app/Http/Controllers/SaleController.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Controllers/SaleController.php) (di dalam method `store`)
* **Jawaban Ideal Mahasiswa:**
  > "Pencegahan stok negatif dilakukan pada lapisan logika bisnis server (*server-side business logic*) di dalam controller penjualan sebelum perintah pengurangan stok dijalankan.
  > Tepatnya pada baris:
  > ```php
  > if ($product->stock < $qty) {
  >     throw ValidationException::withMessages([
  >         'items' => "Stok untuk produk '{$product->name}' tidak mencukupi! Stok tersedia: {$product->stock}, permintaan transaksi: {$qty}."
  >     ]);
  > }
  > ```
  > Jika kuantitas yang diminta pembeli (`$qty`) melebihi stok yang ada di database (`$product->stock`), sistem langsung melempar `ValidationException`. Eksekusi dihentikan seketika dan transaksi penjualan ditolak tanpa pernah memanggil `$product->decrement()`. Selain itu, kami juga menerapkan pemeriksaan di antarmuka klien menggunakan atribut HTML `max` sebagai bantuan UX, namun validasi di server inilah yang menjadi jaminan mutlak integritas data."

---

### Pertanyaan 3: Mengapa total penjualan dihitung di server, bukan dipercaya dari input browser?
* **File Rujukan:** [`app/Http/Controllers/SaleController.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Controllers/SaleController.php)
* **Jawaban Ideal Mahasiswa:**
  > "Karena input dari browser klien berada di luar batas kendali server (*untrusted boundary*). Pengguna yang memiliki niat jahat dapat dengan mudah memodifikasi elemen HTML form, mengedit parameter di DevTools / Inspect Element, atau menembak payload HTTP secara langsung melalui Postman/Curl dengan mengubah harga produk menjadi Rp 1 atau total transaksi menjadi Rp 0.
  > Oleh sebab itu, server hanya menerima `product_id` dan `quantity`. Nilai harga jual (`unit_price`) diambil dan dikunci langsung dari database produk (`$unitPrice = $product->selling_price;`), lalu subtotal dan grand total dihitung murni oleh algoritma server. Ini adalah prinsip dasar keamanan web: *Never Trust Client Input*."

---

### Pertanyaan 4: Apa risiko jika pengurangan stok dilakukan di luar `DB::transaction()`?
* **File Rujukan:** [`app/Http/Controllers/SaleController.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Controllers/SaleController.php)
* **Jawaban Ideal Mahasiswa:**
  > "Risiko terbesarnya adalah kehilangan konsistensi data akibat fenomena **Partial Execution (Data Setengah Tersimpan)**.
  > Misalkan dalam satu penjualan terdapat 3 barang. Jika pengurangan stok atau penyimpanan item ke-3 mengalami error (misalnya koneksi database terputus atau constraint gagal), sementara penyimpanan header dan item ke-1 sudah selesai di luar transaksi:
  > 1. Stok barang ke-1 sudah terpotong, tetapi transaksi penjualannya gagal atau tidak lengkap.
  > 2. Laporan keuangan dan saldo fisik gudang menjadi selisih (*inconsistent state*).
  > Dengan membungkus seluruh alur dalam `DB::transaction()`, sistem menjamin prinsip **Atomicity (All-or-Nothing)** dari ACID: jika salah satu langkah gagal, seluruh perubahan dari awal transaksi akan otomatis di-rollback (dibatalkan kembali) seolah transaksi tersebut belum pernah terjadi."

---

### Pertanyaan 5: Bagaimana mencegah Staff mengakses fungsi Admin melalui URL langsung?
* **File Rujukan:** [`app/Http/Middleware/RoleMiddleware.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Middleware/RoleMiddleware.php) & [`routes/web.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/routes/web.php)
* **Jawaban Ideal Mahasiswa:**
  > "Menyembunyikan menu atau tombol di tampilan Blade hanyalah kosmetik antarmuka dan bukan keamanan otorisasi. Untuk proteksi sejati, kami menerapkan **Server-Side Route Middleware**.
  > Kami mendaftarkan middleware kustom `RoleMiddleware` pada grup route sensitif di `web.php`:
  > ```php
  > Route::middleware('role:admin')->group(function () {
  >     Route::resource('users', UserController::class);
  >     Route::resource('categories', CategoryController::class);
  >     Route::post('/sales/{sale}/cancel', [SaleController::class, 'cancel']);
  > });
  > ```
  > Ketika Staff kasir mencoba mengetik URL langsung seperti `http://localhost:8000/users` atau `http://localhost:8000/categories/create` di address bar browser, `RoleMiddleware` akan memeriksa `auth()->user()->role`. Jika bukan `'admin'`, middleware langsung menghentikan request dan mengembalikan respon **HTTP 403 Forbidden** (*Akses Ditolak*)."

---

### Pertanyaan 6: Apa yang terjadi jika dua penjualan memproses stok produk yang sama hampir bersamaan?
* **File Rujukan:** [`app/Http/Controllers/SaleController.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Controllers/SaleController.php)
* **Jawaban Ideal Mahasiswa:**
  > "Jika tidak diantisipasi, akan terjadi masalah konkurensi klasik yang disebut **Race Condition / Overselling**. Misalkan produk tersisa 1 unit di gudang. Kasir A dan Kasir B sama-sama membuka transaksi di waktu yang hampir bersamaan. Keduanya melihat stok masih 1, lalu keduanya sama-sama menekan tombol bayar. Jika tanpa proteksi, stok 1 dikurangi oleh Kasir A menjadi 0, lalu dikurangi lagi oleh Kasir B menjadi -1.
  > Kami mencegah skenario ini dengan menerapkan **Pessimistic Locking**:
  > ```php
  > $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
  > ```
  > Klausa `lockForUpdate()` akan menginstruksikan MySQL untuk mengunci baris (*row-level lock*) produk tersebut bagi transaksi pertama yang masuk. Transaksi kedua yang mencoba membaca baris yang sama akan dipaksa menunggu (*queued/blocked*) hingga transaksi pertama melakukan commit atau rollback. Begitu transaksi pertama selesai, transaksi kedua baru dapat membaca stok yang sudah berkurang (menjadi 0) dan transaksi kedua akan ditolak dengan pesan stok tidak cukup."

---

### Pertanyaan 7: Tunjukkan validasi SKU unik dan jelaskan peran constraint database.
* **File Rujukan:** [`app/Http/Requests/StoreProductRequest.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/app/Http/Requests/StoreProductRequest.php) & [`database/migrations/2024_01_01_000004_create_products_table.php`](file:///C:/Users/USER/.gemini/antigravity/scratch/inventory-sales/database/migrations/2024_01_01_000004_create_products_table.php)
* **Jawaban Ideal Mahasiswa:**
  > "Validasi SKU unik kami lindungi dalam dua lapis pertahanan (*Defense in Depth*):
  > 1. **Lapisan Aplikasi (Laravel Validation):** Pada `StoreProductRequest`:
  >    ```php
  >    'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
  >    ```
  >    Dan pada `UpdateProductRequest` menggunakan:
  >    ```php
  >    Rule::unique('products', 'sku')->ignore($productId)
  >    ```
  >    Ini memberikan pesan kesalahan ramah (*flash error*) kembali ke form UI pengguna jika ada SKU yang kembar.
  > 2. **Lapisan Database (Database Unique Constraint):** Pada migration tabel produk:
  >    ```php
  >    $table->string('sku', 50)->unique();
  >    ```
  >    Peran constraint database sangat penting sebagai benteng pertahanan terakhir. Jika ada proses impor batch data atau dua request bersamaan yang lolos dari validasi aplikasi, database engine MySQL akan menolak pencatatan duplikasi tersebut (*Integrity Constraint Violation*), sehingga integritas data master SKU dijamin tidak akan pernah korup."

---

### Pertanyaan 8 (Uji Modifikasi Langsung): "Coba ubah aturan minimum stock dan tunjukkan dampaknya!"
* **Skenario Permintaan Dosen:**
  Dosen meminta Anda mengubah batas minimum stok pada suatu produk, misalnya produk yang memiliki stok 10 unit dan semula minimum_stock-nya bernilai 5 unit, diubah batas minimumnya menjadi 15 unit.
* **Langkah Pembuktian Mahasiswa di Depan Dosen:**
  1. Buka menu **Produk & Stok** (`/products`).
  2. Cari produk bersangkutan (misal: *Fast Charger GaN 65W*, stok saat ini: 25 unit).
  3. Klik tombol **Ubah (Edit)**.
  4. Ubah input field **Batas Minimum Stok (Alert)** dari `10` menjadi `30`.
  5. Klik tombol **Perbarui Data Produk**.
  6. **Tunjukkan Dampaknya:**
     - Pada halaman daftar produk, badge stok produk tersebut yang semula berwarna hijau kini otomatis berubah warna menjadi **oranye/merah (Kritis)** dengan efek animasi alert karena kondisi `stock (25) <= minimum_stock (30)` terpenuhi.
     - Buka menu **Dashboard** (`/dashboard`). Tunjukkan bahwa angka kartu metrik **Peringatan Stok Rendah** otomatis bertambah 1 item, dan produk tersebut langsung masuk ke dalam daftar tabel peringatan stok kritis di dashboard secara *real-time*.
     - Jelaskan ke dosen: *'Logika ini berjalan otomatis karena query dashboard menggunakan scope `Product::lowStock()` yang membandingkan kolom stok secara dinamis: `whereColumn("stock", "<=", "minimum_stock")`.'*

---

Dengan menguasai penjelasan teknis dan baris rujukan kode di atas, mahasiswa dapat mendemonstrasikan kepemilikan kode secara paripurna serta meraih nilai maksimal pada komponen penilaian *Code Ownership Interview* (Slide 22).
