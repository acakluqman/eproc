<?php
if (isset($_POST['register'])) {
    $nama = escape($_POST['nama']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    $konfirmasi = escape($_POST['konfirmasi']);

    $cekEmail = $conn->prepare("SELECT email FROM user WHERE email = :email");
    $cekEmail->execute(['email' => $email]);

    if ($cekEmail->rowCount()) {
        $flash->warning('Email telah terdaftar. Silahkan gunakan email yang lain');
    } else {
        if ($password == $konfirmasi) {
            $register = $conn->prepare("INSERT INTO user (nama, email, password, jenis_user) VALUES (:nama, :email, :password, :jenis_user)");
            $register->execute(['nama' => $nama, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'jenis_user' => 3]);

            if ($register) {
                $flash->success('Proses registrasi berhasil. Silahkan login menggunakan email dan password Anda dan lengkapi data perusahaan!');

                header("Location: " . base_url('auth/login'));
                exit();
            } else {
                $flash->warning('Proses registrasi gagal. Silahkan ulangi kembali!');
            }
        } else {
            $flash->warning('Kombinasi password tidak cocok!');
        }
    }
}
?>
<div class="card-body login-card-body">
    <p class="login-box-msg">Form pendaftaran vendor/rekanan</p>

    <?= $flash->display() ?>

    <form action="" class="form" method="post">
        <div class="form-group mb-3">
            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($_POST['nama']) ?: '' ?>" placeholder="Nama Lengkap PIC" autofocus autocomplete="nama-register" required>
        </div>

        <div class="form-group mb-3">
            <input type="email" class="form-control" name="email" id="email" value="<?= isset($_POST['email']) ?: '' ?>" placeholder="Alamat Email PIC" autocomplete="email-register" required>
        </div>

        <div class="form-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" required>
        </div>

        <div class="form-group mb-3">
            <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi Password" required>
        </div>

        <div class="input-group mb-3">
            <button type="submit" name="register" class="btn btn-primary btn-block">DAFTAR SEKARANG</button>
        </div>
    </form>

    <p class="mb-1">
        Kembali ke <a href="<?= base_url() ?>">halaman depan</a>
    </p>
    <p class="mb-1">
        Kembali ke <a href="<?= base_url('auth/login') ?>">halaman login</a>
    </p>
</div>