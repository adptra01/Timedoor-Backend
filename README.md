# Bookstore Rating System

Ini adalah aplikasi backend untuk sistem rating toko buku, dibangun sebagai bagian dari Timedoor Backend Programming Exam.

## Gambaran Umum Proyek

Aplikasi ini bertujuan untuk:

- Menampilkan daftar buku yang dapat difilter dan diurutkan berdasarkan rating.
- Menampilkan top 10 penulis terpopuler berdasarkan jumlah voter (rating > 5).
- Memungkinkan pengguna untuk memberi rating pada buku.

## Teknologi yang Digunakan

- **Backend:** PHP 8.3+, Laravel 12.x
- **Database:** MySQL
- **Seeder:** Laravel Seeder dengan Faker untuk generate data dalam jumlah besar.
- **Frontend:** Blade Template sederhana (untuk tampilan dasar, jika ada).
- **Version Control:** GitHub Public Repo (asumsi).

## Fitur Utama

### 1. Daftar Buku dengan Filter

- **Tampilan Default:** 10 buku teratas berdasarkan `avg_rating` tertinggi.
- **Filter Jumlah Data:** Dropdown untuk menampilkan 10, 20, 30, atau 100 item per halaman.
- **Pencarian:** Input untuk mencari buku berdasarkan judul atau nama penulis.
- **Pengurutan:** Berdasarkan rata-rata rating tertinggi.
- **Data yang Ditampilkan:** Judul buku, Penulis, Rata-rata rating, Jumlah voter, Tahun terbit.

### 2. Top 10 Penulis Terpopuler

- Berdasarkan jumlah voter yang memberi rating di atas 5.
- Diurutkan secara descending berdasarkan jumlah voter.
- **Data yang Ditampilkan:** Nama penulis, Jumlah voter, Rata-rata rating bukunya.

### 3. Input Rating

- Dropdown untuk memilih buku (dapat difilter berdasarkan penulis).
- Dropdown untuk memilih rating (1 – 10).
- Textarea untuk komentar (opsional).
- **Validasi:** Rating harus angka 1-10 dan buku harus valid.
- Setelah submit, akan redirect kembali ke Daftar Buku.

## Struktur Proyek

Berikut adalah gambaran singkat tentang struktur direktori dan komponen utama dalam proyek ini:

- `app/`: Berisi kode inti aplikasi, termasuk model Eloquent, HTTP controllers, requests, resources, dan service providers.
  - `app/Http/Controllers/Api/`: Berisi controller untuk menangani permintaan API.
  - `app/Http/Requests/`: Berisi custom form requests untuk validasi input.
  - `app/Http/Resources/`: Berisi API resources untuk transformasi data respons.
  - `app/Models/`: Berisi definisi model Eloquent untuk interaksi database.
  - `app/Providers/`: Berisi service providers untuk bootstrapping layanan aplikasi.
- `bootstrap/`: Berisi file bootstrapping framework.
- `config/`: Berisi semua file konfigurasi aplikasi.
- `database/`: Berisi migrasi database, factory, dan seeder.
  - `database/factories/`: Berisi definisi factory untuk membuat data dummy.
  - `database/migrations/`: Berisi definisi skema database.
  - `database/seeders/`: Berisi kelas seeder untuk mengisi database dengan data.
- `public/`: Direktori root web yang berisi `index.php` dan aset publik.
- `resources/`: Berisi aset frontend seperti CSS, JavaScript, dan view Blade.
- `routes/`: Berisi semua definisi rute aplikasi (web, api, console).
  - `routes/api.php`: Berisi definisi rute untuk API.
- `storage/`: Berisi file yang dihasilkan oleh framework seperti log, cache, dan file yang diunggah.
- `tests/`: Berisi pengujian unit dan fitur aplikasi.
- `vendor/`: Berisi dependensi Composer.

## Struktur Database (Ringkasan)

Aplikasi ini menggunakan beberapa tabel utama:

- `users`: Informasi pengguna.
- `authors`: Informasi penulis.
- `categories`: Kategori buku.
- `books`: Informasi buku, termasuk relasi ke penulis dan kategori.
- `ratings`: Rating yang diberikan pengguna untuk buku.
- `book_category`: Tabel pivot untuk relasi many-to-many antara buku dan kategori.

Untuk detail skema database yang lebih visual, Anda dapat merujuk pada diagram ERD yang disediakan dalam dokumen `Rancangan_Aplikasi_Timedoor.pdf`.

Jika Anda memiliki file gambar ERD (misalnya `erd.png`), Anda dapat menambahkannya ke direktori proyek dan merujuknya di sini:

```markdown
![Entity Relationship Diagram](D:\laragon\www\timedoor-backend\ERD.png)
```

## Instalasi dan Setup

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi:

1. **Clone Repository:**

   ```bash
   git clone https://github.com/adptra01/Timedoor-Backend.git
   cd timedoor-backend
   ```
2. **Instal Dependensi Composer:**

   ```bash
   composer install
   ```
3. **Konfigurasi Environment:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit file `.env` dan konfigurasikan koneksi database Anda (misalnya untuk MySQL).
4. **Migrasi Database dan Seeding Data (Penting!):
   Aplikasi ini menggunakan seeder yang dioptimalkan untuk data dalam jumlah besar (100.000 buku, 500.000 rating, dll.).

   ```bash
   php artisan migrate:fresh --seed
   ```

   Perintah ini akan menghapus semua tabel, menjalankan migrasi, dan mengisi database dengan data dummy yang banyak. Pastikan `DatabaseSeeder.php` Anda memanggil semua seeder dalam urutan yang benar.
5. **Jalankan Aplikasi:**

   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di `http://127.0.0.1:8000` (atau port lain yang ditentukan).

## Laravel Telescope

Aplikasi ini terintegrasi dengan Laravel Telescope untuk membantu debugging dan pemantauan aplikasi.

Setelah instalasi, Anda dapat mengakses dashboard Telescope di:

```
http://127.0.0.1:8000/telescope
```

Pastikan Anda telah menjalankan migrasi Telescope jika belum:

```bash
php artisan telescope:install
php artisan migrate
```

## Dokumentasi API (Laravel Scramble)

Aplikasi ini menggunakan Laravel Scramble untuk secara otomatis menghasilkan dan menyajikan dokumentasi API berdasarkan kode sumber Anda. Anda dapat mengakses dokumentasi API interaktif di:

```
http://127.0.0.1:8000/docs/api
```

Dokumentasi ini akan menampilkan semua endpoint API, parameter, dan respons yang tersedia.

## Penggunaan API (Contoh)

Beberapa endpoint API utama yang mungkin tersedia:

- `GET /api/v1/books`
- `GET /api/v1/books/{id}`
- `GET /api/v1/authors`
- `GET /api/v1/authors/top` (untuk 10 penulis teratas)
- `POST /api/v1/ratings`

(Detail endpoint dan request/response dapat ditemukan di dokumentasi API atau kode sumber.)
