<?php
/**
 * logout.php
 * Menghapus data login dari session, namun pilihan bahasa dipertahankan.
 */
require __DIR__ . "/includes/init.php";

$bahasa = $_SESSION["lang"];

session_unset();      // kosongkan semua variabel session
session_destroy();    // hancurkan session di server

// Mulai session baru agar pilihan bahasa & pesan logout tetap ada
session_start();
session_regenerate_id(true);
$_SESSION["lang"] = $bahasa;
set_flash("success", t("flash_logout"));

redirect("login.php");
