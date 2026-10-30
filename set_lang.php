<?php
/**
 * set_lang.php
 * Mengganti bahasa antarmuka lalu kembali ke halaman sebelumnya.
 * Pilihan bahasa disimpan di $_SESSION["lang"] agar konsisten di semua halaman.
 */
require __DIR__ . "/includes/init.php";

$pilihan = $_GET["lang"] ?? "id";

switch ($pilihan) {
    case "en":
        $_SESSION["lang"] = "en";
        break;
    case "id":
    default:
        $_SESSION["lang"] = "id";
        break;
}

// Hanya izinkan kembali ke file .php lokal milik aplikasi (mencegah open redirect)
$back = $_GET["back"] ?? "index.php";
if (!preg_match('/^[a-z_]+\.php(\?[A-Za-z0-9_=&%+.\-]*)?$/', $back)) {
    $back = "index.php";
}

redirect($back);
