<?php

if (isset($_POST['email'])) {
    // cek email di db
    $email = $_POST['email'];

    $sqlCekEmail = $conn->prepare("SELECT nama, email FROM user WHERE email = :email");
    $sqlCekEmail->execute(['email' => $email]);
    $user = $sqlCekEmail->fetchObject();

    if ($user) {
        $token = token(50);

        $conn->beginTransaction();
        try {
            // simpan token untuk reset password
            $simpanToken = $conn->prepare("INSERT INTO reset_password (email, token) VALUES(:email, :token)");
            $simpanToken->execute(['email' => $email, 'token' => $token]);

            $data['title'] = 'Reset Password - eProcurement Universitas Wijaya Kusuma Surabaya';
            $data['nama'] = $user->nama;
            $data['message'][0] = 'Kami telah menerima permintaan Anda untuk reset password.';
            $data['message'][1] = 'Silahkan klik link dibawah ini untuk melakukan reset password. Link berlaku sampai 3 jam kedepan!';
            $data['btn_text'] = 'Reset Password';
            $data['btn_link'] = base_url('auth/reset/' . $token);

            $phpmailer->Subject = $data['title'];
            $phpmailer->addAddress($user->email, $user->nama);
            $phpmailer->msgHTML(templateEmail($data));

            if (!$phpmailer->send()) {
                $flash->warning('Gagal melakukan permintaan reset password. Silahkan ulangi kembali! Error: ' . $phpmailer->ErrorInfo);
            } else {
                $flash->success('Link reset password berhasil dikirim. Silahkan cek email untuk reset password!');
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollBack();

            $flash->warning('Gagal melakukan reset password. Silahkan ulangi kembali! Error: ' . $e->getMessage());
        }
    } else {
        $flash->warning('Email tidak terdaftar!');
    }
}
?>
<div class="card-body login-card-body">
    <p class="login-box-msg">Form lupa password</p>

    <?= $flash->display() ?>

    <form action="" method="post">
        <div class="form-group mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="Alamat Email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus autocomplete="email-reset-password" required>
        </div>

        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary btn-block">Kirim Email Reset Kata Sandi</button>
        </div>
    </form>

    <p class="mb-1">
        Kembali ke <a href="<?= base_url() ?>">halaman depan</a>
    </p>
    <p class="mb-1">
        Kembali ke <a href="<?= base_url('auth/login') ?>">halaman login</a>
    </p>
</div>