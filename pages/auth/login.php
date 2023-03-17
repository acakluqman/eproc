<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $login->execute(['email' => $email]);
    $user = $login->fetchObject();

    if ($login->rowCount()) {
        if (password_verify($password, $user->password)) {
            $_SESSION['is_login'] = true;
            $_SESSION['id_user'] = $user->id_user;
            $_SESSION['nama'] = $user->nama;
            $_SESSION['email'] = $user->email;
            $_SESSION['jenis_user'] = $user->jenis_user;
            $_SESSION['id_vendor'] = $user->id_vendor;

            header("Location: " . base_url() . "");
        } else {
            $flash->warning('Akun tidak ditemukan. Periksa kembali email dan kata sandi Anda!');
        }
    } else {
        $flash->warning('Akun tidak ditemukan. Periksa kembali email dan kata sandi Anda!');
    }
}

?>
<div class="card-body login-card-body">
    <p class="login-box-msg">Silahkan masuk untuk mengakses aplikasi e-procurement</p>

    <?= $flash->display() ?>

    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" id="email"
                   value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Email" autofocus
                   autocomplete="email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                   autocomplete="password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary btn-block">MASUK</button>
        </div>
    </form>

    <p class="mb-1">
        Kembali ke <a href="/">halaman depan</a>
    </p>
    <p class="mb-1">
        Lupa kata sandi? <a href="./password">Klik disini</a>
    </p>
    <p class="mb-0">
        Daftar vendor baru? <a href="./register" class="text-center">Klik disini</a>
    </p>
</div>