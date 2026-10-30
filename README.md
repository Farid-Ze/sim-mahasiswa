# SIMADA — Sistem Informasi Manajemen Data Mahasiswa

Tugas 2 Mata Kuliah **Penerapan Teknologi Internet** (2026/2027 Gasal) — Dosen: Donny Reza, M.Kom

| | |
|---|---|
| **Nama** | Dziban Arkan |
| **NIM** | 77961325 |
| **Kelas** | IF-3 |
| **Angkatan** | 2024 |
| **Program Studi** | Teknik Informatika |
| **Universitas** | Universitas Komputer Indonesia (UNIKOM) |

Aplikasi web untuk mengelola data mahasiswa (tambah, lihat, ubah, hapus) yang dibangun dengan **PHP murni** (tanpa framework) dan **MySQL/MariaDB** melalui **PDO**. Aplikasi dilindungi sistem login berbasis `$_SESSION` dan mendukung dua bahasa antarmuka (Indonesia & Inggris).

## Fitur

| Modul | Implementasi |
|---|---|
| Form & Validasi | Form HTML method **POST**; validasi kelengkapan/format dengan **switch** + **if-else** (`includes/validasi.php`); sanitasi dengan `htmlspecialchars()`, `strip_tags()`, `filter_var()` |
| Koneksi Database | PDO + `try-catch` + `ERRMODE_EXCEPTION` (`config/koneksi.php`) |
| Create | `tambah.php` — `INSERT` dengan prepared statement |
| Read | `index.php` — tabel data + statistik + pencarian (GET) |
| Update | `edit.php?id=…` — form terisi data lama, `UPDATE … WHERE id = :id` |
| Delete | `hapus.php` — `DELETE` via POST + konfirmasi + token CSRF |
| Login | `login.php` — `password_verify()`, `$_SESSION["user_id"]`; halaman CRUD dikunci oleh `includes/auth.php` |
| Dual Bahasa | `set_lang.php` menyimpan pilihan di `$_SESSION["lang"]`; kamus di `lang/id.php` & `lang/en.php` |

## Struktur Folder

```
sim-mahasiswa/
├── index.php            # Read  - daftar data mahasiswa (dilindungi login)
├── tambah.php           # Create
├── edit.php             # Update
├── hapus.php            # Delete
├── login.php            # Halaman login
├── logout.php           # Keluar (hapus session)
├── set_lang.php         # Ganti bahasa (ID/EN)
├── config/koneksi.php   # Koneksi PDO
├── includes/
│   ├── init.php         # session_start, bahasa, helper, CSRF
│   ├── auth.php         # Proteksi halaman CRUD
│   ├── validasi.php     # Sanitasi & validasi data form
│   ├── form_mahasiswa.php
│   ├── header.php
│   └── footer.php
├── lang/id.php, lang/en.php
├── assets/css/style.css
├── database/db_kampus.sql
└── docs/                # Laporan PDF & tangkapan layar
```

## Cara Menjalankan (XAMPP)

1. Salin folder `sim-mahasiswa` ke `C:\xampp\htdocs\`.
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin` → tab **Import** → pilih `database/db_kampus.sql` → **Go**.
4. Jika MySQL Anda memakai password, ubah `$password` di `config/koneksi.php`.
5. Buka `http://localhost/sim-mahasiswa/`.
6. Login dengan **username:** `admin` — **password:** `admin123`.

Alternatif tanpa XAMPP: `php -S localhost:8000` di dalam folder proyek, lalu buka `http://localhost:8000`.

## Keamanan yang Diterapkan

- **SQL Injection** → seluruh query yang memakai input pengguna menggunakan prepared statement PDO.
- **XSS** → semua data yang ditampilkan di-escape dengan `htmlspecialchars()`; input dibersihkan dengan `strip_tags()`/`filter_var()`.
- **Password** → disimpan sebagai hash (`password_hash`) dan dicek dengan `password_verify`.
- **Session fixation** → `session_regenerate_id(true)` saat login.
- **CSRF** → token di setiap form POST; penghapusan data hanya lewat POST.
