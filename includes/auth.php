<?php
/**
 * auth.php
 * Pelindung halaman CRUD. Di-require setelah init.php pada setiap
 * halaman yang hanya boleh diakses oleh pengguna yang sudah login.
 *
 * Jika $_SESSION["user_id"] belum ada, pengguna diarahkan ke login.php.
 */
if (!isset($_SESSION["user_id"])) {
    set_flash("error", t("flash_login_dulu"));
    redirect("login.php");
}
