<?php
$vendorSql = $conn->prepare("SELECT * FROM vendor WHERE id_vendor = :id_vendor");
$vendorSql->execute(['id_vendor' => $_SESSION['id_vendor']]);
$vendor = $vendorSql->fetchObject();

if (sizeof($_POST) > 0) {
    if (isset($_POST['profil'])) {
        try {
            $updateSql = $conn->prepare("UPDATE user SET nama = :nama, email = :email WHERE id_user = :id_user");
            $updateSql->execute(['id_user' => $_SESSION['id_user'], 'nama' => $_POST['nama'], 'email' => $_POST['email']]);

            $_SESSION['nama'] = escape($_POST['nama']);
            $_SESSION['email'] = escape($_POST['email']);

            $flash->success('Berhasil memperbarui profil!');
            header('Location: ' . base_url('profil'));
        } catch (PDOException $e) {
            $flash->error('Gagal memperbarui profil! ' . $e->getMessage());
        }
    }

    if (isset($_POST['vendor'])) {
        $ktpFilename = $npwpFilename = $siupFilename = NULL;

        $path = 'upload' . DIRECTORY_SEPARATOR;
        if ($_FILES['file_ktp']['tmp_name']) {
            $checkKtp = getimagesize($_FILES['file_ktp']['tmp_name']);
            $ktpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_ktp']['name'], PATHINFO_EXTENSION);

            if (!$checkKtp) {
                $flash->warning('Format file KTP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
            }

            if ($_FILES["file_ktp"]["size"] > 2097152) {
                $flash->warning('Ukuran file KTP yang dapat diunggah adalah 2MB!');
            }

            if (move_uploaded_file($_FILES["file_ktp"]["tmp_name"], $ktpFilename)) {
                $flash->success("The file " . $ktpFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        if ($_FILES['file_npwp']['tmp_name']) {
            $checkNpwp = getimagesize($_FILES['file_npwp']['tmp_name']);
            $npwpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_npwp']['name'], PATHINFO_EXTENSION);

            if (!$checkNpwp) {
                $flash->warning('Format file NPWP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
            }

            if ($_FILES["file_npwp"]["size"] > 2097152) {
                $flash->warning('Ukuran file NPWP yang dapat diunggah adalah 2MB!');
            }

            if (move_uploaded_file($_FILES["file_npwp"]["tmp_name"], $npwpFilename)) {
                $flash->success("The file " . $npwpFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        if ($_FILES['file_siup']['tmp_name']) {
            $checkMimeSiup = strtolower(pathinfo('upload/' . $_FILES['file_siup']['name'], PATHINFO_EXTENSION));
            $siupFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_siup']['name'], PATHINFO_EXTENSION);

            if (!in_array($checkMimeSiup, ['png', 'jpg', 'jpeg', 'pdf'])) {
                $flash->warning('Format file SIUP yang hanya dapat diunggah adalah .jpg, .jpeg, .png dan .pdf!');
            }

            if ($_FILES["file_siup"]["size"] > 2097152) {
                $flash->warning('Ukuran file NPWP yang dapat diunggah adalah 2MB!');
            }

            if (move_uploaded_file($_FILES["file_siup"]["tmp_name"], $siupFilename)) {
                $flash->success("The file " . $siupFilename . " has been uploaded.");
            } else {
                $flash->warning("Sorry, there was an error uploading your file.");
            }
        }

        $nama = strtoupper($_POST['nama']);
        $alamat = $_POST['alamat'];
        $nama_pemilik = strtoupper($_POST['nama_pemilik']);
        $nik_pemilik = $_POST['nik_pemilik'];
        $file_ktp_path = $ktpFilename ?: $vendor->file_ktp_path;
        $npwp = $_POST['npwp'];
        $nama_npwp = strtoupper($_POST['nama_npwp']);
        $file_npwp_path = $npwpFilename ?: $vendor->file_npwp_path;
        $no_siup = $_POST['siup'];
        $file_siup_path = $siupFilename ?: $vendor->file_siup_path;
        $no_nib = $_POST['nib'];

        $conn->beginTransaction();
        try {
            if ($vendor) {
                $vendorSql = $conn->prepare("UPDATE vendor SET nama = :nama, alamat = :alamat, nama_pemilik = :nama_pemilik, nik_pemilik = :nik_pemilik, file_ktp_path = :file_ktp_path, npwp = :npwp, nama_npwp = :nama_npwp, file_npwp_path = :file_npwp_path, no_siup = :no_siup, file_siup_path = :file_siup_path, no_nib = :no_nib WHERE id_vendor = :id_vendor");
                $vendorSql->execute(['nama' => $nama, 'alamat' => $alamat, 'nama_pemilik' => $nama_pemilik, 'nik_pemilik' => $nik_pemilik, 'file_ktp_path' => $file_ktp_path, 'npwp' => $npwp, 'nama_npwp' => $nama_npwp, 'file_npwp_path' => $file_npwp_path, 'no_siup' => $no_siup, 'file_siup_path' => $file_siup_path, 'no_nib' => $no_nib, 'id_vendor' => $vendor->id_vendor]);
            } else {
                $vendorSql = $conn->prepare("INSERT INTO vendor (nama, alamat, npwp, nama_npwp, file_npwp_path, nama_pemilik, nik_pemilik, file_ktp_path, no_siup, file_siup_path, no_nib) VALUES (:nama, :alamat, :npwp, :nama_npwp, :file_npwp_path, :nama_pemilik, :nik_pemilik, :file_ktp_path, :no_siup, :file_siup_path, :no_nib)");
                $vendorSql->execute(['nama' => $nama, 'alamat' => $alamat, 'npwp' => $npwp, 'nama_npwp' => $nama_npwp, 'file_npwp_path' => $file_npwp_path, 'nama_pemilik' => $nama_pemilik, 'nik_pemilik' => $nik_pemilik, 'file_ktp_path' => $file_ktp_path, 'no_siup' => $no_siup, 'file_siup_path' => $file_siup_path, 'no_nib' => $no_nib]);

                $id_vendor = $conn->lastInsertId();
                $user = $conn->prepare("UPDATE user SET id_vendor = :id_vendor WHERE id_user = :id_user");
                $user->execute(['id_vendor' => $id_vendor, 'id_user' => $_SESSION['id_user']]);

                $_SESSION['id_vendor'] = $id_vendor;
            }

            $conn->commit();
            $flash->success('Berhasil memperbarui data vendor!');
            header('Location:' . base_url('profil'));
        } catch (PDOExecption $e) {
            $conn->rollBack();
            $flash->error('Gagal memperbarui data vendor! ' . $e->getMessage());
        }
    }

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
            $flash->error('Gagal memperbarui password! ' . PDOException($e->getMessage));
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
                    <!-- profil user -->
                    <div class="active tab-pane" id="user">
                        <form action="" class="form" method="post">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                       placeholder="Nama Lengkap" value="<?= $_SESSION['nama'] ?>" autocomplete="nama"
                                       minlength="6"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Alamat Email" value="<?= $_SESSION['email'] ?>" autocomplete="email"
                                       required inputmode="email">
                            </div>

                            <div class="form-group">
                                <button type="submit" name="profil" class="btn btn-primary">
                                    Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- profil vendor -->
                    <div class="tab-pane" id="vendor">
                        <form action="" class="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nama">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                       placeholder="Nama Perusahaan" value="<?= $vendor ? $vendor->nama : '' ?>"
                                       autocomplete="nama" required>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                       placeholder="Alamat Perusahaan" value="<?= $vendor ? $vendor->alamat : '' ?>"
                                       autocomplete="alamat" required>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="nama_pemilik">Nama Pemilik</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                           placeholder="Nama Pemilik"
                                           value="<?= $vendor ? $vendor->nama_pemilik : '' ?>"
                                           autocomplete="nama_pemilik" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="nik_pemilik">NIK Pemilik</label>
                                    <input type="number" class="form-control" id="nik_pemilik" name="nik_pemilik"
                                           placeholder="NIK Pemilik" value="<?= $vendor ? $vendor->nik_pemilik : '' ?>"
                                           autocomplete="nik_pemilik" minlength="16" maxlength="16" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="file_ktp">File KTP</label>
                                    <?= ($vendor && $vendor->file_ktp_path) ? '<a href="' . base_url($vendor->file_ktp_path) . '" target="_blank"><i class="fas fa-image"></i> Lihat file KTP terunggah</a>' : '' ?>
                                    <input type="file" class="form-control" name="file_ktp" id="file_ktp"
                                           accept="image/*" <?= ($vendor && $vendor->file_ktp_path) ? '' : 'required' ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="nama_npwp">Nama di NPWP</label>
                                    <input type="text" class="form-control" id="nama_npwp" name="nama_npwp"
                                           placeholder="Nama di NPWP" value="<?= $vendor ? $vendor->nama_npwp : '' ?>"
                                           autocomplete="nama_npwp" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="npwp">NPWP</label>
                                    <input type="text" class="form-control" id="npwp" name="npwp"
                                           placeholder="NPWP Perusahaan" value="<?= $vendor ? $vendor->npwp : '' ?>"
                                           autocomplete="npwp" minlength="16" maxlength="25" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="file_npwp">File NPWP</label>
                                    <?= ($vendor && $vendor->file_npwp_path) ? '<a href="' . base_url($vendor->file_npwp_path) . '" target="_blank"><i class="fas fa-image"></i> Lihat file NPWP terunggah</a>' : '' ?>
                                    <input type="file" class="form-control" name="file_npwp" id="file_npwp"
                                           accept="image/*" <?= ($vendor && $vendor->file_npwp_path) ? '' : 'required' ?>>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="nib">Nomor NIB</label>
                                    <input type="text" class="form-control" id="nib" name="nib"
                                           placeholder="Nomor NIB" value="<?= $vendor ? $vendor->no_nib : '' ?>"
                                           autocomplete="nib" minlength="15" maxlength="15" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="siup">Nomor SIUP</label>
                                    <input type="text" class="form-control" id="siup" name="siup"
                                           placeholder="Nomor SIUP" value="<?= $vendor ? $vendor->no_siup : '' ?>"
                                           autocomplete="siup" minlength="15" maxlength="15" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="file_siup">File SIUP</label>
                                    <?= ($vendor && $vendor->file_siup_path) ? '<a href="' . base_url($vendor->file_siup_path) . '" target="_blank"><i class="fas fa-image"></i> Lihat file SIUP terunggah</a>' : '' ?>
                                    <input type="file" class="form-control" name="file_siup" id="file_siup"
                                           accept="image/*, application/pdf" <?= ($vendor && $vendor->file_siup_path) ? '' : 'required' ?>>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="vendor" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ganti password -->
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
                                    Ganti Password
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