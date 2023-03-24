<?php
if (sizeof($_POST) > 0) {
    if (isset($_POST['password'])) {
        try {
            $old = $_POST['old'];
            $new = $_POST['new'];
            $confirm = $_POST['confirm'];

            $checkSql = $conn->prepare("SELECT password FROM user WHERE id_user = :id_user");
            $checkSql->execute(['id_user' => $_SESSION['id_user']]);
            $user = $checkSql->fetchObject();

            if (password_verify($old, $user->password)) {
                if ($new != $confirm) {
                    $flash->warning('Konfirmasi password tidak sama!');
                } else {
                    $updateSql = $conn->prepare("UPDATE user SET password = :password WHERE id_user = :id_user");
                    $updateSql->execute(['password' => password_hash($new, PASSWORD_DEFAULT), 'id_user' => $_SESSION['id_user']]);

                    $flash->success('Password berhasil diperbarui!');
                }
            } else {
                $flash->warning('Password lama Anda tidak valid!');
            }
        } catch (PDOException $e) {
            $flash->error(PDOException($e->getMessage));
        }
    }
}
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil Saya</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <?= $flash->display(); ?>
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#user" data-toggle="tab">
                            Profil Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#vendor" data-toggle="tab">
                            Profil Perusahaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#password" data-toggle="tab">
                            Ganti Password
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="user">
                        <p>User</p>
                    </div>
                    <div class="tab-pane" id="vendor">
                        <p>Vendor</p>
                    </div>
                    <div class="tab-pane" id="password">
                        <form action="" class="form" method="post">
                            <div class="form-group">
                                <label for="old">Password Saat Ini</label>
                                <input type="password" class="form-control" id="old" name="old"
                                       placeholder="Password Saat Ini" autocomplete="old-password" minlength="6"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="new">Password Baru</label>
                                <input type="password" class="form-control" id="new" name="new"
                                       placeholder="Password Baru" autocomplete="new-password" minlength="6" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm" name="confirm"
                                       placeholder="Konfirmasi Password Baru" autocomplete="confirm-password"
                                       minlength="6" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="password" class="btn btn-primary">
                                    <i class="fas fa-lock mr-2"></i> Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
    })
</script>