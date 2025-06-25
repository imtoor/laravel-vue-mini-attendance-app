# Mini Attendance App

Aplikasi Mini Absensi dengan Laravel & Vue 3 🚀  
Dibuat menggunakan Laravel Starter Kit (Breeze + Vue).  
Aplikasi ini memiliki dua role yaitu **Admin** dan **Karyawan**.

## 🔗 Live Demo

Ingin mencoba langsung tanpa meng-clone project?  
Kunjungi: [https://laravel-vue-mini-attendance-app-master-onark7.laravel.cloud](https://laravel-vue-mini-attendance-app-master-onark7.laravel.cloud)

---

## 👥 Akun Pengguna

| Nama     | Email               | Peran    | Password |
|----------|---------------------|----------|----------|
| admin    | admin@gmail.com     | Admin    | 123456   |
| karyawan | karyawan@gmail.com  | Karyawan | 123456   |
| dimas    | dimas@gmail.com     | Karyawan | 123456   |
| budi     | budi@gmail.com      | Karyawan | 123456   |

---

## 🛠️ Teknologi yang Digunakan

- Laravel 10+
- Vue 3
- Laravel Breeze Starter Kit (Inertia.js)
- Tailwind CSS

---

## 🚀 Cara Menjalankan Secara Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/imtoor/laravel-vue-mini-attendance-app.git
   cd laravel-vue-mini-attendance-app

2. **Install Dependency Laravel**
   ```bash
   composer install

3. **Install Dependency Frontend**
   ```bash
   npm install

4. **Buat File .env**
   ```bash
   cp .env.example .env

5. **Generate Key dan Setup Database**
   ```bash
   php artisan key:generate
   # Edit .env untuk konfigurasi database
   php artisan migrate

6. **Jalankan Server Laravel**
   ```bash
   php artisan serve

7. **Jalankan Frontend Vue**
   ```bash
   npm run dev

8. **Login ke aplikasi**

  Gunakan salah satu akun dari tabel di atas pada halaman login.

### 📌 Fitur Utama
Login dan Logout

- Role Admin dan Karyawan

- Halaman absensi sederhana

- UI modern dengan Vue 3

### ✨ Catatan

- Semua user menggunakan password yang sama: 123456.
