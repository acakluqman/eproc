<?php
// ambil data user
$id_user = $_SESSION['id_user'];

$sqlUser = $conn->prepare("SELECT * FROM user WHERE id_user = :id_user");
$sqlUser->execute(['id_user' => $id_user]);
$user = $sqlUser->fetchObject();

// perbarui data profil user
if (isset($_POST['profil'])) {
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];

    if (isset($_POST['togglepass'])) {
        // ganti password juga
        $password = $_POST['password'];
        $baru = $_POST['passbaru'];
        $konfirmasi = $_POST['konfirmasi'];

        // cek password lama
        $sqlCekPassword = $conn->prepare("SELECT password FROM user WHERE id_user = :id_user");
        $sqlCekPassword->execute(['id_user' => $id_user]);
        $user = $sqlCekPassword->fetchObject();

        if (password_verify($password, $user->password)) {
            // password ok
            if ($baru == $konfirmasi) {
                $sqlUpdateProfil = $conn->prepare("UPDATE user SET nama = :nama, password = :password WHERE id_user = :id_user");
                $updateProfil = $sqlUpdateProfil->execute(['nama' => $nama, 'password' => password_hash($password, PASSWORD_DEFAULT), 'id_user' => $id_user]);

                if ($updateProfil) {
                    $_SESSION['nama'] = $nama;
                    $flash->success('Berhasil memperbarui profil dan password. Silahkan gunakan password baru Anda ketika login kembali!');
                } else {
                    $flash->warning('Gagal memperbarui profil dan password!');
                }
            } else {
                $flash->warning('Konfirmasi password tidak cocok!');
            }
        } else {
            // password lama tidak valid
            $flash->warning('Password lama tidak cocok!');
        }
    } else {
        // update profil user tanpa ganti password
        $sqlUpdateProfil = $conn->prepare("UPDATE user SET nama = :nama WHERE id_user = :id_user");
        $updateProfil = $sqlUpdateProfil->execute(['nama' => $nama, 'id_user' => $id_user]);

        if ($updateProfil) {
            $_SESSION['nama'] = $nama;
            $flash->success('Berhasil memperbarui profil');
        } else {
            $flash->warning('Gagal memperbarui profil. Silahkan ulangi kembali!');
        }
    }

    header('Location:' . base_url('app/profil'));
    exit();
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profil Saya</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <?= $flash->display() ?>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $_SESSION['nama'] ?></h3>
                        <p class="text-muted text-center">
                            <?php
                            if ($_SESSION['jenis_user'] == 1) {
                                echo 'Administrator';
                            } elseif ($_SESSION['jenis_user'] == 2) {
                                echo 'Petugas LPSE';
                            } elseif ($_SESSION['jenis_user'] == 3) {
                                echo 'Perusahaan Rekanan';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#profil" data-toggle="tab">Profil Saya</a>
                            </li>
                            <?php if ($_SESSION['jenis_user'] == 3) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#vendor" data-toggle="tab">Data Vendor</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="profil">
                                <form class="form" method="post" action="">
                                    <input type="hidden" name="id_user" id="id_user" value="<?= $user->id_user ?>" readonly>
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $user->nama ?>" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 col-form-label">Alamat Email</label>
                                        <div class="col-9">
                                            <input type="email" class="form-control" name="email" id="email" value="<?= $user->email ?>" placeholder="Alamat Email" inputmode="email" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">&nbsp;</label>
                                        <div class="col-9">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="togglepass" id="togglepass">
                                                    Ganti password
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="divpass">
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label">Password Lama</label>
                                            <div class="col-9">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Saat Ini" autocomplete="password-lama">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="passbaru" class="col-sm-3 col-form-label">Password Baru</label>
                                            <div class="col-9">
                                                <input type="password" class="form-control" name="passbaru" id="passbaru" placeholder="Masukkan Password Baru" minlength="6">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="konfirmasi" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                                            <div class="col-9">
                                                <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi Password Baru">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">&nbsp;</label>
                                        <div class="col-9">
                                            <button type="submit" name="profil" class="btn btn-primary"><i class="fas fa-check mr-2"></i>Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php if ($_SESSION['jenis_user'] == 3) : ?>
                                <div class="tab-pane" id="vendor">
                                    <form action="" class="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="form-label">Nama Perusahaan</label>
                                            <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="<?= isset($_POST['nama_perusahaan']) ? $_POST['nama_perusahaan'] : '' ?>" placeholder="Nama Perusahaan" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Alamat Perusahaan</label>
                                            <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" value="<?= isset($_POST['alamat_perusahaan']) ? $_POST['alamat_perusahaan'] : '' ?>" placeholder="Alamat Perusahaan" required>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">Nama Pemilik</label>
                                                <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" value="<?= isset($_POST['nama_pemilik']) ? $_POST['nama_pemilik'] : '' ?>" placeholder="Nama Pemilik" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">NIK Pemilik</label>
                                                <input type="number" class="form-control" name="nik_pemilik" id="nik_pemilik" value="<?= isset($_POST['nik_pemilik']) ? $_POST['nik_pemilik'] : '' ?>" placeholder="NIK Pemilik" minlength="16" maxlength="16" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload KTP Pemilik</label>
                                                <input type="file" class="form-control" name="file_ktp" id="file_ktp" value="" placeholder="Upload KTP" required accept="image/*">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NPWP</label>
                                                <input type="text" class="form-control" name="npwp" id="npwp" value="<?= isset($_POST['npwp']) ? $_POST['npwp'] : '' ?>" placeholder="NPWP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Nama di NPWP</label>
                                                <input type="text" class="form-control" name="nama_npwp" id="nama_npwp" value="<?= isset($_POST['nama_npwp']) ? $_POST['nama_npwp'] : '' ?>" placeholder="Nama di NPWP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload NPWP</label>
                                                <input type="file" class="form-control" name="file_npwp" id="file_npwp" value="" placeholder="Upload NPWP" required accept="image/*">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NIB</label>
                                                <input type="text" class="form-control" name="nib" id="nib" value="<?= isset($_POST['nib']) ? $_POST['nib'] : '' ?>" placeholder="NIB" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">SIUP</label>
                                                <input type="text" class="form-control" name="siup" id="siup" value="<?= isset($_POST['siup']) ? $_POST['siup'] : '' ?>" placeholder="SIUP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload SIUP</label>
                                                <input type="file" class="form-control" name="file_siup" id="file_siup" value="" placeholder="Upload SIUP" required accept="image/*, application/pdf">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="vendor" class="btn btn-primary">
                                                <i class="fas fa-save mr-2"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $("#divpass").hide();

        $("#togglepass").click(function() {
            if ($(this).is(":checked")) {
                $("#divpass").show(300);

                $('#password').prop('required', true);
                $('#passbaru').prop('required', true);
                $('#konfirmasi').prop('required', true);
            } else {
                $("#divpass").hide(200);

                $('#password').prop('required', false);
                $('#passbaru').prop('required', false);
                $('#konfirmasi').prop('required', false);
            }
        });
    });
</script>