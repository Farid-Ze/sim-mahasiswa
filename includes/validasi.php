<?php
/**
 * validasi.php
 * Modul Pengolahan Form Data & Validasi.
 *  1. sanitasi_mahasiswa() : membersihkan data input dari $_POST
 *  2. validasi_mahasiswa() : memeriksa kelengkapan & format data
 *     menggunakan struktur kontrol switch dan if-else
 */

// Daftar program studi yang boleh dipilih (dipakai di <select> dan validasi)
$DAFTAR_JURUSAN = [
    "Teknik Informatika",
    "Sistem Informasi",
    "Teknik Komputer",
    "Desain Komunikasi Visual",
    "Manajemen Informatika",
];

/**
 * Sanitasi data input.
 * - trim() membuang spasi di awal/akhir
 * - strip_tags() membuang tag HTML/script yang disisipkan
 * - filter_var(FILTER_SANITIZE_EMAIL) membuang karakter tidak sah dari email
 * - filter_var(FILTER_SANITIZE_NUMBER_INT) hanya menyisakan angka
 * Saat ditampilkan kembali, data tetap di-escape dengan htmlspecialchars().
 */
function sanitasi_mahasiswa($post)
{
    return [
        "nim"           => filter_var(trim($post["nim"] ?? ""), FILTER_SANITIZE_NUMBER_INT),
        "nama"          => trim(strip_tags($post["nama"] ?? "")),
        "email"         => filter_var(trim($post["email"] ?? ""), FILTER_SANITIZE_EMAIL),
        "jenis_kelamin" => trim($post["jenis_kelamin"] ?? ""),
        "jurusan"       => trim(strip_tags($post["jurusan"] ?? "")),
        "angkatan"      => filter_var(trim($post["angkatan"] ?? ""), FILTER_SANITIZE_NUMBER_INT),
        "alamat"        => trim(strip_tags($post["alamat"] ?? "")),
    ];
}

/**
 * Validasi kelengkapan dan format data sebelum disimpan.
 *
 * @param array    $data      data yang sudah disanitasi
 * @param PDO      $pdo       koneksi database (untuk cek NIM duplikat)
 * @param int|null $id_kecuali ID data yang sedang diubah (mode update)
 * @return array   daftar pesan error (kosong = valid)
 */
function validasi_mahasiswa($data, $pdo, $id_kecuali = null)
{
    global $DAFTAR_JURUSAN;
    $error = [];

    foreach ($data as $field => $nilai) {
        switch ($field) {
            case "nim":
                if ($nilai === "") {
                    $error[$field] = t("err_nim_kosong");
                } elseif (!preg_match('/^[0-9]{8,10}$/', $nilai)) {
                    $error[$field] = t("err_nim_format");
                } else {
                    // NIM harus unik -> cek ke database dengan prepared statement
                    $sql = "SELECT COUNT(*) FROM mahasiswa WHERE nim = :nim";
                    $param = [":nim" => $nilai];
                    if ($id_kecuali !== null) {
                        $sql .= " AND id <> :id";
                        $param[":id"] = $id_kecuali;
                    }
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($param);
                    if ($stmt->fetchColumn() > 0) {
                        $error[$field] = t("err_nim_duplikat");
                    }
                }
                break;

            case "nama":
                if ($nilai === "") {
                    $error[$field] = t("err_nama_kosong");
                } elseif (!preg_match("/^[\p{L} .']{3,100}$/u", $nilai)) {
                    $error[$field] = t("err_nama_format");
                }
                break;

            case "email":
                if ($nilai === "") {
                    $error[$field] = t("err_email_kosong");
                } elseif (filter_var($nilai, FILTER_VALIDATE_EMAIL) === false) {
                    $error[$field] = t("err_email_format");
                }
                break;

            case "jenis_kelamin":
                if ($nilai !== "L" && $nilai !== "P") {
                    $error[$field] = t("err_jk_kosong");
                }
                break;

            case "jurusan":
                if ($nilai === "") {
                    $error[$field] = t("err_jurusan_kosong");
                } elseif (!in_array($nilai, $DAFTAR_JURUSAN, true)) {
                    $error[$field] = t("err_jurusan_invalid");
                }
                break;

            case "angkatan":
                $tahun_ini = (int) date("Y");
                $opsi = ["options" => ["min_range" => 2000, "max_range" => $tahun_ini]];
                if ($nilai === "") {
                    $error[$field] = t("err_angkatan_kosong");
                } elseif (filter_var($nilai, FILTER_VALIDATE_INT, $opsi) === false) {
                    $error[$field] = sprintf(t("err_angkatan_format"), $tahun_ini);
                }
                break;

            case "alamat":
                // Alamat opsional, tetapi dibatasi panjangnya
                if (mb_strlen($nilai) > 255) {
                    $error[$field] = t("err_alamat_panjang");
                }
                break;

            default:
                // field lain diabaikan
                break;
        }
    }

    return $error;
}
