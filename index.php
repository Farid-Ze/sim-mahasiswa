<?php
/**
 * index.php  (READ)
 * Menampilkan seluruh data mahasiswa dari database ke dalam tabel HTML.
 * Dilengkapi pencarian menggunakan method GET (cocok untuk filter data).
 * Halaman ini dilindungi: hanya bisa dibuka setelah login.
 */
require __DIR__ . "/includes/init.php";
require __DIR__ . "/includes/auth.php";

$cari = trim($_GET["cari"] ?? "");

try {
    if ($cari !== "") {
        // Pencarian -> prepared statement dengan named parameter
        $stmt = $pdo->prepare(
            "SELECT * FROM mahasiswa
             WHERE nim LIKE :kata1 OR nama LIKE :kata2 OR jurusan LIKE :kata3
             ORDER BY nama ASC"
        );
        $kata = "%" . $cari . "%";
        $stmt->execute([":kata1" => $kata, ":kata2" => $kata, ":kata3" => $kata]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM mahasiswa ORDER BY nama ASC");
        $stmt->execute();
    }
    $mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ringkasan (query tanpa input pengguna -> cukup query())
    $statistik = $pdo->query(
        "SELECT COUNT(*) AS total,
                SUM(jenis_kelamin = 'L') AS laki,
                SUM(jenis_kelamin = 'P') AS perempuan,
                COUNT(DISTINCT jurusan) AS jurusan
         FROM mahasiswa"
    )->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(e(sprintf(t("flash_db_error"), $e->getMessage())));
}

$judul_halaman = t("dash_title");
$halaman_aktif = "data";
require __DIR__ . "/includes/header.php";
?>

<div class="page-head">
    <div>
        <h1><?= e(t("dash_title")) ?></h1>
        <p class="muted"><?= e(t("dash_sub")) ?></p>
    </div>
    <a href="tambah.php" class="btn btn-primary">+ <?= e(t("nav_tambah")) ?></a>
</div>

<section class="stats">
    <div class="stat"><span class="stat-num"><?= (int) $statistik["total"] ?></span><span class="stat-label"><?= e(t("stat_total")) ?></span></div>
    <div class="stat"><span class="stat-num"><?= (int) $statistik["laki"] ?></span><span class="stat-label"><?= e(t("stat_l")) ?></span></div>
    <div class="stat"><span class="stat-num"><?= (int) $statistik["perempuan"] ?></span><span class="stat-label"><?= e(t("stat_p")) ?></span></div>
    <div class="stat"><span class="stat-num"><?= (int) $statistik["jurusan"] ?></span><span class="stat-label"><?= e(t("stat_jurusan")) ?></span></div>
</section>

<section class="card">
    <form method="GET" action="index.php" class="searchbar">
        <input type="search" name="cari" value="<?= e($cari) ?>" placeholder="<?= e(t("search_placeholder")) ?>">
        <button type="submit" class="btn btn-secondary"><?= e(t("btn_cari")) ?></button>
        <?php if ($cari !== ""): ?>
            <a href="index.php" class="btn btn-ghost"><?= e(t("btn_reset")) ?></a>
        <?php endif; ?>
    </form>

    <?php if ($cari !== ""): ?>
        <p class="search-info"><?= e(sprintf(t("hasil_cari"), $cari, count($mahasiswa))) ?></p>
    <?php endif; ?>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th class="num"><?= e(t("th_no")) ?></th>
                    <th><?= e(t("th_nim")) ?></th>
                    <th><?= e(t("th_nama")) ?></th>
                    <th><?= e(t("th_email")) ?></th>
                    <th class="center"><?= e(t("th_jk")) ?></th>
                    <th><?= e(t("th_jurusan")) ?></th>
                    <th class="center"><?= e(t("th_angkatan")) ?></th>
                    <th class="center"><?= e(t("th_aksi")) ?></th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($mahasiswa) === 0): ?>
                <tr><td colspan="8" class="empty"><?= e(t("data_kosong")) ?></td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                <tr>
                    <td class="num"><?= $no++ ?></td>
                    <td class="mono"><?= e($mhs["nim"]) ?></td>
                    <td class="strong"><?= e($mhs["nama"]) ?></td>
                    <td><?= e($mhs["email"]) ?></td>
                    <td class="center">
                        <span class="badge badge-<?= $mhs["jenis_kelamin"] === "L" ? "l" : "p" ?>">
                            <?= e($mhs["jenis_kelamin"] === "L" ? t("jk_l") : t("jk_p")) ?>
                        </span>
                    </td>
                    <td><?= e($mhs["jurusan"]) ?></td>
                    <td class="center"><?= e($mhs["angkatan"]) ?></td>
                    <td class="center actions">
                        <a href="edit.php?id=<?= (int) $mhs["id"] ?>" class="btn btn-sm btn-secondary"><?= e(t("btn_edit")) ?></a>
                        <form method="POST" action="hapus.php" class="inline"
                              onsubmit="return confirm(<?= e(json_encode(t("confirm_hapus"))) ?>);">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $mhs["id"] ?>">
                            <button type="submit" class="btn btn-sm btn-danger"><?= e(t("btn_hapus")) ?></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
