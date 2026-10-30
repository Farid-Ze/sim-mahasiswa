<?php
/**
 * File konfigurasi koneksi database (PDO).
 * Dipanggil dengan require di setiap halaman yang butuh database,
 * sehingga kode koneksi tidak perlu ditulis berulang.
 *
 * Sesuaikan $username dan $password dengan MySQL/MariaDB di komputer Anda
 * (XAMPP default: root tanpa password).
 */
$host     = "localhost";
$nama_db  = "db_kampus";
$username = "root";
$password = "";

$dsn = "mysql:host=" . $host . ";dbname=" . $nama_db . ";charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    // Mode error berupa exception -> setiap error dilempar sebagai PDOException
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Hasil fetch default berupa array asosiatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // die() menghentikan script agar tidak lanjut tanpa koneksi database
    die("Koneksi gagal: " . htmlspecialchars($e->getMessage()));
}
