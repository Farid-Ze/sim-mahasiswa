<?php
/**
 * Kamus Bahasa Indonesia.
 * Berupa array asosiatif: key => teks yang ditampilkan.
 */
return [
    "html_lang"           => "id",
    "app_name"            => "SIMADA",
    "app_full"            => "Sistem Informasi Manajemen Data Mahasiswa",
    "bahasa"              => "Bahasa",

    // Navigasi
    "nav_data"            => "Data Mahasiswa",
    "nav_tambah"          => "Tambah Data",
    "nav_logout"          => "Keluar",
    "welcome"             => "Halo, %s",

    // Login
    "login_title"         => "Masuk ke Sistem",
    "login_sub"           => "Gunakan akun admin untuk mengelola data mahasiswa.",
    "username"            => "Username",
    "password"            => "Password",
    "btn_login"           => "Masuk",
    "login_hint"          => "Akun demo: admin / admin123",
    "err_login_kosong"    => "Username dan password wajib diisi.",
    "err_login_salah"     => "Username atau password salah.",
    "flash_login_dulu"    => "Silakan login terlebih dahulu untuk mengakses halaman ini.",
    "flash_login_ok"      => "Selamat datang, %s!",
    "flash_logout"        => "Anda telah keluar dari sistem.",

    // Dashboard / daftar data
    "dash_title"          => "Data Mahasiswa",
    "dash_sub"            => "Kelola seluruh data mahasiswa yang tersimpan di database.",
    "stat_total"          => "Total Mahasiswa",
    "stat_l"              => "Laki-laki",
    "stat_p"              => "Perempuan",
    "stat_jurusan"        => "Program Studi",
    "search_placeholder"  => "Cari NIM, nama, atau program studi…",
    "btn_cari"            => "Cari",
    "btn_reset"           => "Reset",
    "hasil_cari"          => "Hasil pencarian \"%s\": %d data ditemukan.",
    "th_no"               => "No",
    "th_nim"              => "NIM",
    "th_nama"             => "Nama",
    "th_email"            => "Email",
    "th_jk"               => "L/P",
    "th_jurusan"          => "Program Studi",
    "th_angkatan"         => "Angkatan",
    "th_aksi"             => "Aksi",
    "btn_edit"            => "Ubah",
    "btn_hapus"           => "Hapus",
    "confirm_hapus"       => "Yakin ingin menghapus data mahasiswa ini?",
    "data_kosong"         => "Belum ada data mahasiswa.",

    // Form tambah / ubah
    "form_tambah_title"   => "Tambah Data Mahasiswa",
    "form_tambah_sub"     => "Isi formulir berikut untuk menyimpan data mahasiswa baru.",
    "form_edit_title"     => "Ubah Data Mahasiswa",
    "form_edit_sub"       => "Perbarui data mahasiswa berdasarkan identitas unik (ID) yang dipilih.",
    "lbl_nim"             => "NIM",
    "lbl_nama"            => "Nama Lengkap",
    "lbl_email"           => "Email",
    "lbl_jk"              => "Jenis Kelamin",
    "lbl_jurusan"         => "Program Studi",
    "lbl_angkatan"        => "Angkatan",
    "lbl_alamat"          => "Alamat",
    "jk_l"                => "Laki-laki",
    "jk_p"                => "Perempuan",
    "pilih_jurusan"       => "-- Pilih Program Studi --",
    "opsional"            => "opsional",
    "hint_nim"            => "8–10 digit angka",
    "btn_simpan"          => "Simpan",
    "btn_update"          => "Simpan Perubahan",
    "btn_batal"           => "Batal",

    // Validasi
    "err_title"           => "Data belum dapat disimpan. Periksa kembali isian berikut:",
    "err_nim_kosong"      => "NIM wajib diisi.",
    "err_nim_format"      => "NIM harus berupa 8–10 digit angka.",
    "err_nim_duplikat"    => "NIM sudah terdaftar pada data lain.",
    "err_nama_kosong"     => "Nama lengkap wajib diisi.",
    "err_nama_format"     => "Nama hanya boleh berisi huruf, spasi, titik, atau apostrof (3–100 karakter).",
    "err_email_kosong"    => "Email wajib diisi.",
    "err_email_format"    => "Format email tidak valid.",
    "err_jk_kosong"       => "Jenis kelamin wajib dipilih.",
    "err_jurusan_kosong"  => "Program studi wajib dipilih.",
    "err_jurusan_invalid" => "Program studi yang dipilih tidak dikenal.",
    "err_angkatan_kosong" => "Angkatan wajib diisi.",
    "err_angkatan_format" => "Angkatan harus berupa tahun antara 2000 dan %d.",
    "err_alamat_panjang"  => "Alamat maksimal 255 karakter.",
    "err_csrf"            => "Sesi formulir tidak valid. Silakan muat ulang halaman dan coba lagi.",

    // Pesan hasil proses
    "flash_tambah_ok"     => "Data mahasiswa %s berhasil ditambahkan.",
    "flash_edit_ok"       => "Data mahasiswa %s berhasil diubah.",
    "flash_hapus_ok"      => "Data mahasiswa %s berhasil dihapus.",
    "flash_tidak_ada"     => "Data mahasiswa tidak ditemukan.",
    "flash_db_error"      => "Terjadi kesalahan database: %s",

    "footer"              => "Tugas 2 Penerapan Teknologi Internet · Dziban Arkan (77961325) · IF-3 · Teknik Informatika UNIKOM",
];
