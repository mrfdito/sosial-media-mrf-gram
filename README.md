<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# MRF.GR4M

[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

**MRF.GR4M** adalah sebuah aplikasi sosial media mini berbasis web yang dibangun dari nol menggunakan Laravel 10. Proyek ini dibuat sebagai latihan untuk mengimplementasikan fitur-fitur inti dari sebuah platform sosial, termasuk autentikasi, postingan, interaksi (like & comment), hingga chat antar pengguna.

Aplikasi ini mengusung desain yang simpel, minimalis, dan _dark mode friendly_ dengan _tech stack_ modern tanpa bergantung pada _full-stack framework_ seperti Livewire atau Inertia.js.

---

## ✨ Fitur Utama (Key Features)

-   👤 **Autentikasi & Profil**: Sistem registrasi dan login yang aman. Pengguna memiliki profil publik yang dapat dilihat oleh orang lain dan halaman untuk mengedit profil mereka sendiri (nama & bio).

-   ✍️ **Postingan (Threats)**: Pengguna dapat membuat postingan teks (disebut "Threats") yang akan muncul di _timeline_ utama.

-   ❤️ **Interaksi Pengguna**: Kemampuan untuk memberikan "Like" dan menuliskan "Komentar" pada setiap postingan.

-   ✉️ **Real-Time Chat**: Fitur chat privat antar pengguna yang dibangun dengan _simple polling_ (AJAX) untuk memberikan pengalaman _real-time_ tanpa dependensi eksternal seperti Pusher.

-   🔍 **Pencarian Pengguna**: _Navbar_ dilengkapi dengan fitur pencarian untuk menemukan pengguna lain dengan mudah, lengkap dengan avatar dan tautan langsung ke profil mereka.

-   🎨 **Desain Minimalis**: Tampilan antarmuka yang bersih dan modern dibangun dengan Tailwind CSS dan interaktivitas ringan menggunakan Alpine.js.

---

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 10
-   **Frontend**: Tailwind CSS 3, Alpine.js 3
-   **Database**: MySQL / MariaDB
-   **Avatar**: [UI Avatars](https://ui-avatars.com/) (Generate otomatis berdasarkan nama)

---

## 📸 Tampilan Aplikasi (Screenshots)

_Berikan beberapa screenshot untuk menampilkan visual aplikasi Anda._

|             Halaman Dashboard             |             Halaman Profil             |             Halaman Chat             |
| :---------------------------------------: | :------------------------------------: | :----------------------------------: |
| _[Letakkan screenshot dashboard di sini]_ | _[Letakkan screenshot profil di sini]_ | _[Letakkan screenshot chat di sini]_ |

---

## 🚀 Instalasi Lokal (Local Installation)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

**Prasyarat:**

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   Database (misalnya MySQL, MariaDB)

**Langkah-langkah:**

1.  **Clone repository ini:**

    ```bash
    git clone [https://github.com/username/mrf.gr4m.git](https://github.com/username/mrf.gr4m.git)
    cd mrf.gr4m
    ```

2.  **Install dependensi PHP & JavaScript:**

    ```bash
    composer install
    npm install
    ```

3.  **Buat file environment:**
    Salin file `.env.example` menjadi `.env`. File ini diabaikan oleh Git.

    ```bash
    cp .env.example .env
    ```

4.  **Generate kunci aplikasi:**

    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi database di file `.env`:**
    Sesuaikan variabel `DB_*` dengan kredensial database lokal Anda.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mrf_gram
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan migrasi database:**
    Perintah ini akan membuat semua tabel yang dibutuhkan oleh aplikasi.

    ```bash
    php artisan migrate
    ```

7.  **Jalankan server pengembangan:**

    -   **Vite (untuk kompilasi aset frontend):**
        ```bash
        npm run dev
        ```
    -   **Server Lokal Laravel (di terminal terpisah):**
        ```bash
        php artisan serve
        ```

8.  **Selesai!**
    Buka `http://127.0.0.1:8000` di browser Anda untuk melihat aplikasi berjalan.

---

## 📁 Struktur Folder Penting

Berikut adalah beberapa direktori kunci dalam struktur proyek Laravel ini.

---

## 🤝 Kontribusi (Contributing)

Proyek ini bersifat _open source_ dan dibuat untuk tujuan pembelajaran. Kontribusi, _issue_, dan permintaan fitur sangat diterima. Jangan ragu untuk membuat _fork_, melakukan perubahan, dan mengirimkan _pull request_.

1.  Fork proyek ini.
2.  Buat _feature branch_ baru (`git checkout -b feature/AmazingFeature`).
3.  _Commit_ perubahan Anda (`git commit -m 'Add some AmazingFeature'`).
4.  _Push_ ke _branch_ Anda (`git push origin feature/AmazingFeature`).
5.  Buka _Pull Request_.

---

## 📄 Lisensi (License)

Proyek ini dilisensikan di bawah **MIT License**.

MIT License

Copyright (c) 2025 Muhammad Rizqi Ferdhinandito

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN A ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
>>>>>>> a5a5fdf (perubahan readme)
