<?php
/**
 * tambah.php  (CREATE)
 * Menampilkan form tambah data dan menyimpan data baru ke tabel mahasiswa.
 * Alur: form (POST) -> sanitasi -> validasi -> INSERT (prepared statement).
 */
require __DIR__ . "/includes/init.php";
require __DIR__ . "/includes/auth.php";
require __DIR__ . "/includes/validasi.php";

// Nilai awal form kosong
$data = [
    "nim" => "", "nama" => "", "email" => "", "jenis_kelamin" => "",
    "jurusan" => "", "angkatan" => "", "alamat" => "",
];
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrf_valid()) {
        $error["csrf"] = t("err_csrf");
    } else {
        // 1. Sanitasi
        $data = sanitasi_mahasiswa($_POST);

        // 2. Validasi kelengkapan & format
        $error = validasi_mahasiswa($data, $pdo);

        // 3. Simpan jika tidak ada error
        if (empty($error)) {
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO mahasiswa (nim, nama, email, jenis_kelamin, jurusan, angkatan, alamat)
                     VALUES (:nim, :nama, :email, :jenis_kelamin, :jurusan, :angkatan, :alamat)"
                );
                $stmt->execute([
                    ":nim"           => $data["nim"],
                    ":nama"          => $data["nama"],
                    ":email"         => $data["email"],
                    ":jenis_kelamin" => $data["jenis_kelamin"],
                    ":jurusan"       => $data["jurusan"],
                    ":angkatan"      => $data["angkatan"],
                    ":alamat"        => $data["alamat"],
                ]);

                set_flash("success", sprintf(t("flash_tambah_ok"), $data["nama"]));
                redirect("index.php");
            } catch (PDOException $e) {
                $error["db"] = sprintf(t("flash_db_error"), $e->getMessage());
            }
        }
    }
}

$judul_halaman = t("form_tambah_title");
$halaman_aktif = "tambah";
$mode          = "tambah";
require __DIR__ . "/includes/header.php";
?>

<div class="page-head">
    <div>
        <h1><?= e(t("form_tambah_title")) ?></h1>
        <p class="muted"><?= e(t("form_tambah_sub")) ?></p>
    </div>
</div>

<?php require __DIR__ . "/includes/form_mahasiswa.php"; ?>

<?php require __DIR__ . "/includes/footer.php"; ?>
