<?php
// cek token
$token = escape($_GET['token']);

$sqlCekToken = $conn->prepare("SELECT * FROM reset_password WHERE token = :token");
$sqlCekToken->execute(['token' => $token]);
$reset = $sqlCekToken->fetchObject();

$diff = round(abs(strtotime('now') - strtotime($reset->tgl_reset)) / 3600, 1);

if ($diff <= 3) {
    if (isset($_POST['reset'])) {
        $password = escape($_POST['password']);
        $konfirmasi = escape($_POST['konfirmasi']);

        if ($password == $konfirmasi) {
            // update password
            $sqlUpdatePassword = $conn->prepare("UPDATE user SET password = :password WHERE email = :email");
            $updatePassword = $sqlUpdatePassword->execute(['password' => password_hash($password, PASSWORD_DEFAULT), 'email' => $reset->email]);

            if ($updatePassword) {
                $flash->success('Password berhasil diperbarui. Silahkan login menggunakan password baru Anda!');

                // hapus record reset_password berdasarkan token diatas
                $sqlHapusToken = $conn->prepare("DELETE FROM reset_password WHERE token = :token");
                $hapusToken = $sqlHapusToken->execute(['token' => $token]);

                header('Location:' . base_url('auth/login'));
                exit();
            } else {
                $flash->warning('Gagal memperbarui password. Silahkan ulangi kembali!');
            }
        } else {
            $flash->warning('Kombinasi password tidak cocok!');
        }
    }
} else {
    $flash->warning('Token reset password sudah kadaluarsa. Silahkan isi form dibawah ini untuk meminta link reset password kembali!');

    header('Location:' . base_url('auth/forgot'));
    exit();
}
?>
<div class="card-body login-card-body">
    <p class="login-box-msg">Form reset password</p>

    <?= $flash->display() ?>

    <form action="" class="form" method="post">
        <div class="form-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" required>
        </div>

        <div class="form-group mb-3">
            <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi Password" required>
        </div>

        <div class="input-group mb-3">
            <button type="submit" name="reset" class="btn btn-primary btn-block">RESET PASSWORD</button>
        </div>
    </form>

    <p class="mb-1">
        Kembali ke <a href="<?= base_url() ?>">halaman depan</a>
    </p>
    <p class="mb-1">
        Kembali ke <a href="<?= base_url('auth/login') ?>">halaman login</a>
    </p>
</div>