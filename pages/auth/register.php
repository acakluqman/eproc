<?php
if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekEmail = $conn->prepare("SELECT email FROM user WHERE email = :email");
    $cekEmail->execute(['email' => $email]);

    if ($cekEmail->rowCount()) {
        $flash->warning('Email telah terdaftar. Silahkan gunakan email yang lain');
    } else {
        $register = $conn->prepare("INSERT INTO user (nama, email, password, jenis_user) VALUES (:nama, :email, :password, :jenis_user)");
        $register->execute(['nama' => $nama, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'jenis_user' => 3]);

        if ($register) {
            $flash->success('Proses registrasi berhasil. Silahkan login menggunakan email dan password Anda!');
        } else {
            $flash->warning('Proses registrasi gagal. Silahkan ulangi kembali!');
        }
    }
}
?>
<div class="card-body login-card-body">
    <p class="login-box-msg">Form pendaftaran vendor baru</p>

    <?= $flash->display() ?>

    <form action="" class="form" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-key"></span>
                </div>
            </div>
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