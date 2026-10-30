<?php
/**
 * hapus.php  (DELETE)
 * Menghapus satu data mahasiswa berdasarkan id.
 * Hanya menerima method POST + token CSRF, sehingga data tidak bisa
 * terhapus hanya dengan membuka sebuah link.
 */
require __DIR__ . "/includes/init.php";
require __DIR__ . "/includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !csrf_valid()) {
    set_flash("error", t("err_csrf"));
    redirect("index.php");
}

$id = filter_var($_POST["id"] ?? "", FILTER_VALIDATE_INT);

if ($id === false) {
    set_flash("error", t("flash_tidak_ada"));
    redirect("index.php");
}

try {
    // Ambil nama untuk pesan konfirmasi
    $stmt = $pdo->prepare("SELECT nama FROM mahasiswa WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $mhs = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mhs) {
        set_flash("error", t("flash_tidak_ada"));
    } else {
        $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
        $stmt->execute([":id" => $id]);

        if ($stmt->rowCount() > 0) {
            set_flash("success", sprintf(t("flash_hapus_ok"), $mhs["nama"]));
        } else {
            set_flash("error", t("flash_tidak_ada"));
        }
    }
} catch (PDOException $e) {
    set_flash("error", sprintf(t("flash_db_error"), $e->getMessage()));
}

redirect("index.php");
