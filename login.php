<?php
/**
 * login.php
 * Halaman login. Form dan pemrosesan berada dalam satu file:
 * saat pertama dibuka hanya menampilkan form, setelah form dikirim
 * (method POST) data diperiksa lalu disimpan ke $_SESSION.
 */
require __DIR__ . "/includes/init.php";

// Jika sudah login, langsung ke halaman data
if (isset($_SESSION["user_id"])) {
    redirect("index.php");
}

$error    = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitasi input
    $username = trim(htmlspecialchars($_POST["username"] ?? "", ENT_QUOTES, "UTF-8"));
    $password = $_POST["password"] ?? "";

    // Validasi kelengkapan (if-else)
    if (!csrf_valid()) {
        $error = t("err_csrf");
    } elseif ($username === "" || $password === "") {
        $error = t("err_login_kosong");
    } else {
        // Cari user dengan prepared statement (aman dari SQL Injection)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([":username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cocokkan password dengan hash yang tersimpan
        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);     // cegah session fixation
            $_SESSION["user_id"]      = $user["id"];
            $_SESSION["username"]     = $user["username"];
            $_SESSION["nama_lengkap"] = $user["nama_lengkap"];

            set_flash("success", sprintf(t("flash_login_ok"), $user["nama_lengkap"]));
            redirect("index.php");
        } else {
            $error = t("err_login_salah");
        }
    }
}

$judul_halaman = t("login_title");
$tanpa_nav     = true;
require __DIR__ . "/includes/header.php";
?>

<section class="auth-wrap">
    <div class="auth-card">
        <div class="auth-head">
            <span class="brand-mark brand-mark-lg">S</span>
            <h1><?= e(t("login_title")) ?></h1>
            <p class="muted"><?= e(t("login_sub")) ?></p>
        </div>

        <?php if ($error !== ""): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= e($_SERVER["PHP_SELF"]) ?>" novalidate>
            <?= csrf_field() ?>
            <div class="field">
                <label for="username"><?= e(t("username")) ?></label>
                <input type="text" id="username" name="username" value="<?= e($username) ?>"
                       autocomplete="username" autofocus>
            </div>
            <div class="field">
                <label for="password"><?= e(t("password")) ?></label>
                <input type="password" id="password" name="password" autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary btn-block"><?= e(t("btn_login")) ?></button>
        </form>

        <p class="auth-hint"><?= e(t("login_hint")) ?></p>
    </div>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
