<?php
/**
 * edit.php  (UPDATE)
 * Menyediakan form untuk mengubah data yang sudah ada berdasarkan
 * identitas unik (kolom id). Form terisi otomatis dengan data lama.
 */
require __DIR__ . "/includes/init.php";
require __DIR__ . "/includes/auth.php";
require __DIR__ . "/includes/validasi.php";

// Ambil id dari URL (GET) atau dari form (POST), pastikan berupa angka bulat
$id = filter_var($_POST["id"] ?? $_GET["id"] ?? "", FILTER_VALIDATE_INT);

if ($id === false) {
    set_flash("error", t("flash_tidak_ada"));
    redirect("index.php");
}

// Ambil data lama berdasarkan id
$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = :id");
$stmt->execute([":id" => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    set_flash("error", t("flash_tidak_ada"));
    redirect("index.php");
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrf_valid()) {
        $error["csrf"] = t("err_csrf");
    } else {
        // Sanitasi lalu validasi (NIM boleh sama dengan miliknya sendiri)
        $input       = sanitasi_mahasiswa($_POST);
        $error       = validasi_mahasiswa($input, $pdo, $id);
        $data        = array_merge($data, $input);   // isi ulang form dengan input terbaru

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare(
                    "UPDATE mahasiswa SET
                        nim = :nim, nama = :nama, email = :email,
                        jenis_kelamin = :jenis_kelamin, jurusan = :jurusan,
                        angkatan = :angkatan, alamat = :alamat
                     WHERE id = :id"
                );
                $stmt->execute([
                    ":nim"           => $input["nim"],
                    ":nama"          => $input["nama"],
                    ":email"         => $input["email"],
                    ":jenis_kelamin" => $input["jenis_kelamin"],
                    ":jurusan"       => $input["jurusan"],
                    ":angkatan"      => $input["angkatan"],
                    ":alamat"        => $input["alamat"],
                    ":id"            => $id,
                ]);

                set_flash("success", sprintf(t("flash_edit_ok"), $input["nama"]));
                redirect("index.php");
            } catch (PDOException $e) {
                $error["db"] = sprintf(t("flash_db_error"), $e->getMessage());
            }
        }
    }
}

// Pastikan nilai null (misal alamat kosong) tidak mengganggu tampilan form
$data["alamat"] = $data["alamat"] ?? "";

$judul_halaman = t("form_edit_title");
$halaman_aktif = "data";
$mode          = "edit";
require __DIR__ . "/includes/header.php";
?>

<div class="page-head">
    <div>
        <h1><?= e(t("form_edit_title")) ?></h1>
        <p class="muted"><?= e(t("form_edit_sub")) ?> <span class="id-chip">ID #<?= (int) $data["id"] ?></span></p>
    </div>
</div>

<?php require __DIR__ . "/includes/form_mahasiswa.php"; ?>

<?php require __DIR__ . "/includes/footer.php"; ?>
