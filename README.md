# SPK Minuman Sehat - Sistem Pendukung Keputusan

![Laravel](https://img.shields.io/badge/Laravel-10.x-red) ![PHP](https://img.shields.io/badge/PHP-8.1+-blue) ![License](https://img.shields.io/badge/License-MIT-green)

## 📖 Tentang Proyek

**SPK Minuman Sehat** adalah Sistem Pendukung Keputusan (Decision Support System) berbasis web untuk memberikan rekomendasi minuman sehat menggunakan metode **SAW (Simple Additive Weighting)**. Sistem ini mengevaluasi berbagai alternatif minuman berdasarkan kriteria nutrisi seperti kadar gula, kalori, lemak, protein, dan karbohidrat.

### ✨ Fitur Utama

- 🔐 **Autentikasi** - Login dan logout dengan session management
- 📊 **Analisis Multi-Kriteria** - Evaluasi minuman berdasarkan 5 kriteria nutrisi
- 🏆 **Ranking Otomatis** - Perhitungan SAW menghasilkan peringkat minuman terbaik
- ✏️ **CRUD Lengkap** - Kelola data minuman, kriteria, sub-kriteria, dan admin
- 🎨 **UI Modern** - Interface yang intuitif dan responsif
- ✅ **Validasi Input** - Form validation dengan pesan error dalam Bahasa Indonesia
- 🛡️ **Keamanan** - Protected routes, mass assignment protection, CSRF protection

## 🚀 Instalasi

### Prasyarat

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional, untuk development)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd Big-Project
```

2. **Install Dependencies**
```bash
composer install
```

3. **Konfigurasi Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env` dan sesuaikan dengan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_minuman
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi dan Seeder**
```bash
php artisan migrate:fresh --seed
```

6. **Jalankan Aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, gunakan kredensial berikut untuk login:

- **Email**: `admin@example.com`
- **Password**: `password123`

## 📚 Penggunaan

### 1. Login
Akses halaman `/login` dan masukkan kredensial admin.

### 2. Kelola Data Master

#### Minuman
- Tambah data minuman dengan informasi nutrisi (gula, kalori, lemak, protein, karbohidrat)
- Edit atau hapus data minuman yang ada

#### Kriteria
- Kelola kriteria evaluasi (C1-C5)
- Setiap kriteria memiliki bobot dan atribut (cost/benefit)
- Total bobot harus = 1.0

#### Sub-Kriteria
- Definisikan range nilai untuk setiap kriteria
- Range digunakan untuk konversi nilai asli ke skala 1-5

#### Admin
- Kelola user yang dapat mengakses sistem

### 3. Lihat Ranking
Akses halaman `/spk` untuk melihat:
- **Data Awal** - Konversi nilai nutrisi ke skala 1-5
- **Normalisasi** - Matrix R hasil normalisasi SAW
- **Ranking Final** - Urutan minuman dari yang terbaik

## 🔬 Metode SAW (Simple Additive Weighting)

### Algoritma

1. **Konversi ke Skala (Matrix X)**
   - Nilai nutrisi asli dikonversi ke skala 1-5 berdasarkan range sub-kriteria

2. **Normalisasi (Matrix R)**
   - **Benefit**: R = X / Max(X)
   - **Cost**: R = Min(X) / X

3. **Perhitungan Skor (V)**
   - V = Σ(R × W)
   - W = Bobot kriteria

4. **Ranking**
   - Alternatif diurutkan berdasarkan skor tertinggi

## 🏗️ Struktur Proyek

```
Big-Project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Login/Logout
│   │   │   ├── DrinkController.php      # CRUD Minuman
│   │   │   ├── CriteriaController.php   # CRUD Kriteria
│   │   │   ├── SubCriteriaController.php # CRUD Sub-Kriteria
│   │   │   ├── UserController.php       # CRUD User
│   │   │   └── SpkController.php        # Perhitungan SAW
│   │   ├── Requests/                    # Form Validations
│   │   │   ├── DrinkRequest.php
│   │   │   ├── CriteriaRequest.php
│   │   │   ├── SubCriteriaRequest.php
│   │   │   ├── UserRequest.php
│   │   │   └── LoginRequest.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Drink.php
│   │   ├── Criteria.php
│   │   ├── SubCriteria.php
│   │   └── User.php
│   └── Services/
│       └── SpkService.php               # Business Logic SAW
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── layouts/
│       │   └── main.blade.php
│       ├── drinks/
│       ├── criterias/
│       ├── subcriterias/
│       └── spk/
└── routes/
    └── web.php
```

## 🔒 Keamanan

- ✅ Form Request Validation pada semua input
- ✅ Mass Assignment Protection dengan explicit `$fillable`
- ✅ Password Hashing otomatis
- ✅ CSRF Token pada semua form
- ✅ Authentication Middleware
- ✅ Database Query dengan Eloquent ORM
- ✅ Error Handling dan Logging

## 🛠️ Teknologi

- **Backend**: Laravel 10.x
- **Database**: MySQL
- **Frontend**: Blade Templates, Bootstrap 5
- **Authentication**: Laravel built-in Auth
- **Icons**: Font Awesome 6

## 📝 Kriteria Evaluasi

| Kode | Nama | Atribut | Bobot | Deskripsi |
|------|------|---------|-------|-----------|
| C1 | Gula | Cost | 0.35 | Kadar gula (g) - semakin rendah semakin baik |
| C2 | Energi | Cost | 0.20 | Kalori (kcal) - semakin rendah semakin baik |
| C3 | Lemak | Cost | 0.15 | Kadar lemak (g) - semakin rendah semakin baik |
| C4 | Protein | Benefit | 0.20 | Kadar protein (g) - semakin tinggi semakin baik |
| C5 | Karbohidrat | Cost | 0.10 | Kadar karbohidrat (g) - semakin rendah semakin baik |

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buat pull request untuk perbaikan atau fitur baru.

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

## 📧 Kontak

Untuk pertanyaan atau saran, silakan hubungi:
- Email: admin@example.com

---

**Catatan Pengembangan**: Proyek ini telah melalui audit keamanan dan code quality improvement. Semua controller menggunakan Form Request validation, service layer untuk business logic, dan comprehensive error handling.
