<?php
/**
 * init.php
 * File pertama yang di-require oleh setiap halaman.
 *  - Memulai session (wajib sebelum ada output apa pun)
 *  - Memuat bahasa antarmuka sesuai pilihan di $_SESSION["lang"]
 *  - Menyediakan fungsi-fungsi bantu (helper)
 */
session_start();

require __DIR__ . "/../config/koneksi.php";

/* ------------------------------------------------------------------
 * FITUR DUAL BAHASA
 * Bahasa yang dipilih disimpan di $_SESSION["lang"] sehingga tetap
 * konsisten walaupun pengguna berpindah halaman.
 * ------------------------------------------------------------------ */
if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "id";              // default: Bahasa Indonesia
}

switch ($_SESSION["lang"]) {
    case "en":
        $lang = require __DIR__ . "/../lang/en.php";
        break;
    case "id":
    default:
        $lang = require __DIR__ . "/../lang/id.php";
        break;
}

/**
 * Mengambil teks terjemahan berdasarkan key dari array bahasa.
 * Jika key tidak ada, key itu sendiri yang dikembalikan.
 */
function t($key)
{
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : $key;
}

/**
 * Singkatan htmlspecialchars() untuk menampilkan data ke HTML
 * (mencegah Cross-Site Scripting / XSS).
 */
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, "UTF-8");
}

/** Pindah ke halaman lain lalu hentikan script. */
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

/** Simpan pesan sekali tampil (flash message) di session. */
function set_flash($tipe, $pesan)
{
    $_SESSION["flash"] = ["tipe" => $tipe, "pesan" => $pesan];
}

/** Ambil lalu hapus flash message dari session. */
function get_flash()
{
    if (isset($_SESSION["flash"])) {
        $flash = $_SESSION["flash"];
        unset($_SESSION["flash"]);
        return $flash;
    }
    return null;
}

/* ------------------------------------------------------------------
 * Token CSRF: memastikan form POST benar-benar dikirim dari aplikasi ini
 * ------------------------------------------------------------------ */
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION["csrf_token"]) . '">';
}

function csrf_valid()
{
    return isset($_POST["csrf_token"])
        && hash_equals($_SESSION["csrf_token"], (string) $_POST["csrf_token"]);
}
