<?php
// ambil data user
$id_user = $_SESSION['id_user'];

$sqlUser = $conn->prepare("SELECT * FROM user WHERE id_user = :id_user");
$sqlUser->execute(['id_user' => $id_user]);
$user = $sqlUser->fetchObject();

// ambil data vendor
$vendor = [];
if ($_SESSION['jenis_user'] == 3 && !is_null($_SESSION['id_vendor'])) {
    $id_vendor = $_SESSION['id_vendor'];
    $sqlVendor = $conn->prepare("SELECT * FROM vendor WHERE id_vendor = :id_vendor");
    $sqlVendor->execute(['id_vendor' => $id_vendor]);

    $vendor = $sqlVendor->fetchObject();
}

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

// perbarui data vendor
if (isset($_POST['vendor'])) {
    $conn->beginTransaction();
    try {
        $ktpFilename = $npwpFilename = $siupFilename = null;

        $path = 'upload' . DIRECTORY_SEPARATOR;
        if ($_FILES['file_ktp']['tmp_name']) {
            $checkKtp = getimagesize($_FILES['file_ktp']['tmp_name']);
            $ktpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_ktp']['name'], PATHINFO_EXTENSION);

            // if (!$checkKtp) {
            //     $flash->warning('Format file KTP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
            // }

            // if ($_FILES["file_ktp"]["size"] > 2097152) {
            //     $flash->warning('Ukuran file KTP yang dapat diunggah adalah 2MB!');
            // }

            if (move_uploaded_file($_FILES["file_ktp"]["tmp_name"], $ktpFilename)) {
                $flash->success("The file " . $ktpFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        if ($_FILES['file_npwp']['tmp_name']) {
            $checkNpwp = getimagesize($_FILES['file_npwp']['tmp_name']);
            $npwpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_npwp']['name'], PATHINFO_EXTENSION);

            // if (!$checkNpwp) {
            //     $flash->warning('Format file NPWP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
            // }

            // if ($_FILES["file_npwp"]["size"] > 2097152) {
            //     $flash->warning('Ukuran file NPWP yang dapat diunggah adalah 2MB!');
            // }

            if (move_uploaded_file($_FILES["file_npwp"]["tmp_name"], $npwpFilename)) {
                $flash->success("The file " . $npwpFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        if ($_FILES['file_siup']['tmp_name']) {
            $checkMimeSiup = strtolower(pathinfo('upload/' . $_FILES['file_siup']['name'], PATHINFO_EXTENSION));
            $siupFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_siup']['name'], PATHINFO_EXTENSION);

            // if (!in_array($checkMimeSiup, ['png', 'jpg', 'jpeg', 'pdf'])) {
            //     $flash->warning('Format file SIUP yang hanya dapat diunggah adalah .jpg, .jpeg, .png dan .pdf!');
            // }

            // if ($_FILES["file_siup"]["size"] > 2097152) {
            //     $flash->warning('Ukuran file NPWP yang dapat diunggah adalah 2MB!');
            // }

            if (move_uploaded_file($_FILES["file_siup"]["tmp_name"], $siupFilename)) {
                $flash->success("The file " . $siupFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        if (strlen(str_replace('_', '', $_POST['nik_pemilik'])) != 16) {
            $flash->warning('Format NIK tidak valid!');
        } elseif (strlen(str_replace('_', '', $_POST['npwp'])) != 20) {
            $flash->warning('Format NPWP tidak valid!');
        } else {
            $insertVendor = $conn->prepare("INSERT INTO vendor (nama, alamat, nama_pemilik, nik_pemilik, file_ktp_path, npwp, nama_npwp, file_npwp_path, no_siup, file_siup_path, no_nib) VALUES (:nama, :alamat, :nama_pemilik, :nik_pemilik, :file_ktp_path, :npwp, :nama_npwp, :file_npwp_path, :no_siup, :file_siup_path, :no_nib)");
            $update = $insertVendor->execute([
                'nama' => strtoupper(escape($_POST['nama_perusahaan'])),
                'alamat' => escape($_POST['alamat_perusahaan']),
                'nama_pemilik' => escape($_POST['nama_pemilik']),
                'nik_pemilik' => str_replace('_', '', escape($_POST['nik_pemilik'])),
                'file_ktp_path' => $ktpFilename,
                'npwp' => str_replace('_', '', escape($_POST['npwp'])),
                'nama_npwp' => escape($_POST['nama_npwp']),
                'file_npwp_path' => $npwpFilename,
                'no_siup' => str_replace('_', '', escape($_POST['siup'])),
                'file_siup_path' => $siupFilename,
                'no_nib' => str_replace('_', '', escape($_POST['nib'])),
            ]);

            $id_vendor = $conn->lastInsertId();

            $user = $conn->prepare("UPDATE user SET id_vendor = :id_vendor WHERE id_user = :id_user");
            $user->execute(['id_vendor' => $id_vendor, 'id_user' => $_SESSION['id_user']]);

            $_SESSION['id_vendor'] = $id_vendor;
        }

        $conn->commit();
        $flash->success('Berhasil memperbarui data vendor!');

        header('Location:' . base_url('app/profil'));
    } catch (PDOExecption $e) {
        $conn->rollBack();
        $flash->error('Gagal memperbarui data vendor! ' . $e->getMessage());
    }
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
            <?php if (!cekStatusPendaftaranVendor()) : ?>
                <div class="col-12">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <p class="mb-0"><strong>Pendaftaran Belum Lengkap</strong></p>
                            <p class="mb-0">
                                Akun anda belum disetujui untuk menjadi rekanan. Silahkan lengkapi data dan dokumen persyaratan terlebih dahulu untuk memudahkan proses verifikasi.
                                <br>
                                Klik <strong>Tab Data Rekanan</strong> untuk melengkapi data perusahaan Anda!
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="https://ui-avatars.com/api/?background=a0a0a0&color=fff&name=<?= $_SESSION['nama'] ?>&format=svg&bold=true" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $_SESSION['nama'] ?></h3>
                        <p class="text-muted text-center">
                            <?php
                            if ($_SESSION['jenis_user'] == 1) {
                                echo 'Administrator';
                            } elseif ($_SESSION['jenis_user'] == 2) {
                                echo 'Petugas LPSE';
                            } elseif ($_SESSION['jenis_user'] == 3) {
                                echo $vendor && $vendor->nama ?: 'Perusahaan Rekanan';
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
                                    <a class="nav-link" href="#vendor" data-toggle="tab">Data Rekanan</a>
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
                                            <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="<?= ($vendor && $vendor->nama) ? $vendor->nama : '' ?>" placeholder="Nama Perusahaan" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Alamat Perusahaan</label>
                                            <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" value="<?= ($vendor && $vendor->alamat) ? $vendor->alamat : '' ?>" placeholder="Alamat Perusahaan" required>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">Nama Pemilik</label>
                                                <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" value="<?= ($vendor && $vendor->nama_pemilik) ? $vendor->nama_pemilik : '' ?>" placeholder="Nama Pemilik" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">NIK Pemilik</label>
                                                <input type="text" class="form-control" name="nik_pemilik" id="nik_pemilik" value="<?= ($vendor && $vendor->nik_pemilik) ? $vendor->nik_pemilik : '' ?>" placeholder="NIK Pemilik" data-inputmask='"mask": "9999999999999999"' data-mask minlength="16" maxlength="16" inputmode="numeric" required>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if ($vendor && $vendor->file_ktp_path) : ?>
                                                    <label class="form-label">Dokumen KTP</label>
                                                    <p class="pt-2"><a href="<?= base_url($vendor->file_ktp_path) ?>" target="_blank"><i class="fas fa-link mr-2"></i>Lihat dokumen</a></p>
                                                <?php else : ?>
                                                    <label class="form-label">Upload KTP Pemilik</label>
                                                    <input type="file" class="form-control" name="file_ktp" id="file_ktp" value="" placeholder="Upload KTP" required accept="image/*">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NPWP</label>
                                                <input type="text" class="form-control" name="npwp" id="npwp" value="<?= ($vendor && $vendor->npwp) ? $vendor->npwp : '' ?>" placeholder="NPWP" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Nama di NPWP</label>
                                                <input type="text" class="form-control" name="nama_npwp" id="nama_npwp" value="<?= ($vendor && $vendor->nama_npwp) ? $vendor->nama_npwp : '' ?>" placeholder="Nama di NPWP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if ($vendor && $vendor->file_npwp_path) : ?>
                                                    <label class="form-label">Dokumen NPWP</label>
                                                    <p class="pt-2"><a href="<?= base_url($vendor->file_npwp_path) ?>" target="_blank"><i class="fas fa-link mr-2"></i>Lihat dokumen</a></p>
                                                <?php else : ?>
                                                    <label class="form-label">Upload NPWP</label>
                                                    <input type="file" class="form-control" name="file_npwp" id="file_npwp" value="" placeholder="Upload NPWP" required accept="image/*">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NIB</label>
                                                <input type="text" class="form-control" name="nib" id="nib" value="<?= ($vendor && $vendor->no_nib) ? $vendor->no_nib : '' ?>" placeholder="NIB" data-inputmask='"mask": "***************"' data-mask required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">SIUP</label>
                                                <input type="text" class="form-control" name="siup" id="siup" value="<?= ($vendor && $vendor->no_siup) ? $vendor->no_siup : '' ?>" placeholder="SIUP" data-inputmask='"mask": "***************"' data-mask required>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if ($vendor && $vendor->file_siup_path) : ?>
                                                    <label class="form-label">Dokumen SIUP</label>
                                                    <p class="pt-2"><a href="<?= base_url($vendor->file_siup_path) ?>" target="_blank"><i class="fas fa-link mr-2"></i>Lihat dokumen</a></p>
                                                <?php else : ?>
                                                    <label class="form-label">Upload SIUP</label>
                                                    <input type="file" class="form-control" name="file_siup" id="file_siup" value="" placeholder="Upload SIUP" required accept="image/*, application/pdf">
                                                <?php endif; ?>
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
        $('[data-mask]').inputmask()

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