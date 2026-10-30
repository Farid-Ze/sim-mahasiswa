<?php
/**
 * form_mahasiswa.php
 * Form input data mahasiswa yang dipakai bersama oleh tambah.php dan edit.php.
 * Variabel yang harus tersedia:
 *   $data  : array nilai field (untuk mengisi ulang form)
 *   $error : array pesan error per field
 *   $mode  : "tambah" | "edit"
 */
global $DAFTAR_JURUSAN;

/** Menampilkan pesan error di bawah field tertentu. */
function pesan_error($error, $field)
{
    if (isset($error[$field])) {
        echo '<p class="field-error">' . e($error[$field]) . '</p>';
    }
}
?>

<?php if (!empty($error)): ?>
<div class="alert alert-error">
    <strong><?= e(t("err_title")) ?></strong>
    <ul>
        <?php foreach ($error as $pesan): ?>
            <li><?= e($pesan) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="<?= e(basename($_SERVER["PHP_SELF"])) ?><?= $mode === "edit" ? "?id=" . (int) $data["id"] : "" ?>"
      class="card form-grid" novalidate>
    <?= csrf_field() ?>
    <?php if ($mode === "edit"): ?>
        <input type="hidden" name="id" value="<?= (int) $data["id"] ?>">
    <?php endif; ?>

    <div class="field <?= isset($error["nim"]) ? "has-error" : "" ?>">
        <label for="nim"><?= e(t("lbl_nim")) ?> <span class="req">*</span></label>
        <input type="text" id="nim" name="nim" inputmode="numeric" maxlength="10"
               value="<?= e($data["nim"]) ?>" placeholder="<?= e(t("hint_nim")) ?>">
        <?php pesan_error($error, "nim"); ?>
    </div>

    <div class="field <?= isset($error["nama"]) ? "has-error" : "" ?>">
        <label for="nama"><?= e(t("lbl_nama")) ?> <span class="req">*</span></label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($data["nama"]) ?>">
        <?php pesan_error($error, "nama"); ?>
    </div>

    <div class="field <?= isset($error["email"]) ? "has-error" : "" ?>">
        <label for="email"><?= e(t("lbl_email")) ?> <span class="req">*</span></label>
        <input type="email" id="email" name="email" maxlength="100" value="<?= e($data["email"]) ?>">
        <?php pesan_error($error, "email"); ?>
    </div>

    <div class="field <?= isset($error["jenis_kelamin"]) ? "has-error" : "" ?>">
        <span class="label"><?= e(t("lbl_jk")) ?> <span class="req">*</span></span>
        <div class="radio-group">
            <label class="radio">
                <input type="radio" name="jenis_kelamin" value="L" <?= $data["jenis_kelamin"] === "L" ? "checked" : "" ?>>
                <?= e(t("jk_l")) ?>
            </label>
            <label class="radio">
                <input type="radio" name="jenis_kelamin" value="P" <?= $data["jenis_kelamin"] === "P" ? "checked" : "" ?>>
                <?= e(t("jk_p")) ?>
            </label>
        </div>
        <?php pesan_error($error, "jenis_kelamin"); ?>
    </div>

    <div class="field <?= isset($error["jurusan"]) ? "has-error" : "" ?>">
        <label for="jurusan"><?= e(t("lbl_jurusan")) ?> <span class="req">*</span></label>
        <select id="jurusan" name="jurusan">
            <option value=""><?= e(t("pilih_jurusan")) ?></option>
            <?php foreach ($DAFTAR_JURUSAN as $jurusan): ?>
                <option value="<?= e($jurusan) ?>" <?= $data["jurusan"] === $jurusan ? "selected" : "" ?>><?= e($jurusan) ?></option>
            <?php endforeach; ?>
        </select>
        <?php pesan_error($error, "jurusan"); ?>
    </div>

    <div class="field <?= isset($error["angkatan"]) ? "has-error" : "" ?>">
        <label for="angkatan"><?= e(t("lbl_angkatan")) ?> <span class="req">*</span></label>
        <input type="number" id="angkatan" name="angkatan" min="2000" max="<?= date("Y") ?>"
               value="<?= e($data["angkatan"]) ?>" placeholder="<?= date("Y") ?>">
        <?php pesan_error($error, "angkatan"); ?>
    </div>

    <div class="field field-full <?= isset($error["alamat"]) ? "has-error" : "" ?>">
        <label for="alamat"><?= e(t("lbl_alamat")) ?> <span class="muted">(<?= e(t("opsional")) ?>)</span></label>
        <textarea id="alamat" name="alamat" rows="3" maxlength="255"><?= e($data["alamat"]) ?></textarea>
        <?php pesan_error($error, "alamat"); ?>
    </div>

    <div class="form-actions field-full">
        <a href="index.php" class="btn btn-ghost"><?= e(t("btn_batal")) ?></a>
        <button type="submit" class="btn btn-primary">
            <?= e($mode === "edit" ? t("btn_update") : t("btn_simpan")) ?>
        </button>
    </div>
</form>
