<?php
/**
 * header.php
 * Bagian atas tampilan (HTML head + navigasi).
 * Variabel yang dapat diatur sebelum include:
 *   $judul_halaman : judul pada tab browser
 *   $halaman_aktif : "data" | "tambah" (menandai menu aktif)
 *   $tanpa_nav     : true untuk halaman login
 */
$judul_halaman = $judul_halaman ?? t("app_name");
$halaman_aktif = $halaman_aktif ?? "";
$tanpa_nav     = $tanpa_nav ?? false;

// Alamat halaman saat ini, dipakai agar setelah ganti bahasa kembali ke halaman yang sama
$halaman_ini = basename($_SERVER["PHP_SELF"]);
if (!empty($_SERVER["QUERY_STRING"])) {
    $halaman_ini .= "?" . $_SERVER["QUERY_STRING"];
}
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="<?= e(t("html_lang")) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul_halaman) ?> · <?= e(t("app_name")) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= $tanpa_nav ? "page-auth" : "page-app" ?>">

<header class="topbar">
    <div class="container topbar-inner">
        <a class="brand" href="<?= isset($_SESSION["user_id"]) ? "index.php" : "login.php" ?>">
            <span class="brand-mark">S</span>
            <span class="brand-text">
                <strong><?= e(t("app_name")) ?></strong>
                <small><?= e(t("app_full")) ?></small>
            </span>
        </a>

        <?php if (!$tanpa_nav && isset($_SESSION["user_id"])): ?>
        <nav class="mainnav">
            <a href="index.php" class="<?= $halaman_aktif === "data" ? "active" : "" ?>"><?= e(t("nav_data")) ?></a>
            <a href="tambah.php" class="<?= $halaman_aktif === "tambah" ? "active" : "" ?>"><?= e(t("nav_tambah")) ?></a>
        </nav>
        <?php endif; ?>

        <div class="topbar-right">
            <div class="lang-switch" role="group" aria-label="<?= e(t("bahasa")) ?>">
                <a href="set_lang.php?lang=id&amp;back=<?= urlencode($halaman_ini) ?>"
                   class="<?= $_SESSION["lang"] === "id" ? "active" : "" ?>" title="Bahasa Indonesia">ID</a>
                <a href="set_lang.php?lang=en&amp;back=<?= urlencode($halaman_ini) ?>"
                   class="<?= $_SESSION["lang"] === "en" ? "active" : "" ?>" title="English">EN</a>
            </div>

            <?php if (!$tanpa_nav && isset($_SESSION["user_id"])): ?>
            <span class="user-chip"><?= e(sprintf(t("welcome"), $_SESSION["nama_lengkap"])) ?></span>
            <a class="btn btn-ghost btn-sm" href="logout.php"><?= e(t("nav_logout")) ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="container main">
<?php if ($flash): ?>
    <div class="alert alert-<?= e($flash["tipe"]) ?>" role="status"><?= e($flash["pesan"]) ?></div>
<?php endif; ?>
