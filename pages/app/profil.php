<?php
// simpan data vendor
if (isset($_POST['vendor'])) {
    $path = 'upload' . DIRECTORY_SEPARATOR;
    $checkKtp = getimagesize($_FILES['file_ktp']['tmp_name']);
    $checkNpwp = getimagesize($_FILES['file_npwp']['tmp_name']);
    $checkMimeSiup = strtolower(pathinfo('upload/' . $_FILES['file_siup']['name'], PATHINFO_EXTENSION));
    $ktpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_ktp']['name'], PATHINFO_EXTENSION);
    $npwpFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_ktp']['name'], PATHINFO_EXTENSION);
    $siupFilename = $path . uniqid() . '.' . pathinfo($_FILES['file_ktp']['name'], PATHINFO_EXTENSION);

    if (!$checkKtp) {
        $flash->warning('Format file KTP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
    } elseif (!$checkNpwp) {
        $flash->warning('Format file NPWP yang hanya dapat diunggah adalah .jpg, .jpeg dan .png!');
    } elseif ($_FILES["file_ktp"]["size"] > 2097152 || $_FILES["file_ktp"]["size"] > 2097152 || $_FILES["file_siup"]["size"] > 2097152) {
        $flash->warning('Ukuran file yang dapat diunggah adalah 2MB!');
    } elseif (!in_array($checkMimeSiup, ['png', 'jpg', 'jpeg', 'pdf'])) {
        $flash->warning('Format file SIUP yang hanya dapat diunggah adalah .jpg, .jpeg, .png dan .pdf!');
    }

    if (move_uploaded_file($_FILES["file_ktp"]["tmp_name"], $ktpFilename)) {
        $flash->success("The file " . $ktpFilename . " has been uploaded.");
    } else {
        $flash->warning("Sorry, there was an error uploading your file.");
    }

    if (move_uploaded_file($_FILES["file_npwp"]["tmp_name"], $npwpFilename)) {
        $flash->success("The file " . $npwpFilename . " has been uploaded.");
    } else {
        $flash->warning("Sorry, there was an error uploading your file.");
    }

    if (move_uploaded_file($_FILES["file_siup"]["tmp_name"], $siupFilename)) {
        $flash->success("The file " . $siupFilename . " has been uploaded.");
    } else {
        $flash->warning("Sorry, there was an error uploading your file.");
    }

    $nama = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat_perusahaan'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $nik_pemilik = $_POST['nik_pemilik'];
    $file_ktp_path = $ktpFilename;
    $npwp = $_POST['npwp'];
    $nama_npwp = $_POST['nama_npwp'];
    $file_npwp_path = $npwpFilename;
    $no_siup = $_POST['siup'];
    $file_siup_path = $siupFilename;
    $no_nib = $_POST['nib'];

    try {
        $conn->beginTransaction();

        $vendor = $conn->prepare("INSERT INTO vendor (nama, alamat, npwp, nama_npwp, file_npwp_path, nama_pemilik, nik_pemilik, file_ktp_path, no_siup, file_siup_path, no_nib) VALUES (:nama, :alamat, :npwp, :nama_npwp, :file_npwp_path, :nama_pemilik, :nik_pemilik, :file_ktp_path, :no_siup, :file_siup_path, :no_nib)");
        $vendor->execute(['nama' => $nama, 'alamat' => $alamat, 'npwp' => $npwp, 'nama_npwp' => $nama_npwp, 'file_npwp_path' => $file_npwp_path, 'nama_pemilik' => $nama_pemilik, 'nik_pemilik' => $nik_pemilik, 'file_ktp_path' => $file_ktp_path, 'no_siup' => $no_siup, 'file_siup_path' => $file_siup_path, 'no_nib' => $no_nib]);

        $user = $conn->prepare("UPDATE user SET id_vendor = :id_vendor WHERE id_user = :id_user");
        $user->execute(['id_vendor' => $conn->lastInsertId(), 'id_user' => $_SESSION['id_user']]);

        $conn->commit();
    } catch (PDOExecption $e) {
        $conn->rollBack();
        throw new Exception($e->getMessage());
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                                 alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $_SESSION['nama'] ?></h3>
                        <p class="text-muted text-center">Software Engineer</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
                            <li class="nav-item">
                                <a class="nav-link" href="#password" data-toggle="tab">Ubah Password</a>
                            </li>
                            <?php if ($_SESSION['jenis_user'] == 3): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#vendor" data-toggle="tab">Data Vendor</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="profil">
                                <p>Profil</p>
                            </div>
                            <div class="tab-pane" id="password">
                                <p>Password</p>
                            </div>
                            <?php if ($_SESSION['jenis_user'] == 3): ?>
                                <div class="tab-pane" id="vendor">
                                    <form action="" class="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="form-label">Nama Perusahaan</label>
                                            <input type="text" class="form-control" name="nama_perusahaan"
                                                   id="nama_perusahaan"
                                                   value="<?= isset($_POST['nama_perusahaan']) ? $_POST['nama_perusahaan'] : '' ?>"
                                                   placeholder="Nama Perusahaan" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Alamat Perusahaan</label>
                                            <input type="text" class="form-control" name="alamat_perusahaan"
                                                   id="alamat_perusahaan"
                                                   value="<?= isset($_POST['alamat_perusahaan']) ? $_POST['alamat_perusahaan'] : '' ?>"
                                                   placeholder="Alamat Perusahaan" required>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">Nama Pemilik</label>
                                                <input type="text" class="form-control" name="nama_pemilik"
                                                       id="nama_pemilik"
                                                       value="<?= isset($_POST['nama_pemilik']) ? $_POST['nama_pemilik'] : '' ?>"
                                                       placeholder="Nama Pemilik" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">NIK Pemilik</label>
                                                <input type="number" class="form-control" name="nik_pemilik"
                                                       id="nik_pemilik"
                                                       value="<?= isset($_POST['nik_pemilik']) ? $_POST['nik_pemilik'] : '' ?>"
                                                       placeholder="NIK Pemilik" minlength="16" maxlength="16" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload KTP Pemilik</label>
                                                <input type="file" class="form-control" name="file_ktp" id="file_ktp"
                                                       value="" placeholder="Upload KTP" required accept="image/*">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NPWP</label>
                                                <input type="text" class="form-control" name="npwp" id="npwp"
                                                       value="<?= isset($_POST['npwp']) ? $_POST['npwp'] : '' ?>"
                                                       placeholder="NPWP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Nama di NPWP</label>
                                                <input type="text" class="form-control" name="nama_npwp" id="nama_npwp"
                                                       value="<?= isset($_POST['nama_npwp']) ? $_POST['nama_npwp'] : '' ?>"
                                                       placeholder="Nama di NPWP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload NPWP</label>
                                                <input type="file" class="form-control" name="file_npwp" id="file_npwp"
                                                       value="" placeholder="Upload NPWP" required accept="image/*">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="form-label">NIB</label>
                                                <input type="text" class="form-control" name="nib" id="nib"
                                                       value="<?= isset($_POST['nib']) ? $_POST['nib'] : '' ?>"
                                                       placeholder="NIB" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">SIUP</label>
                                                <input type="text" class="form-control" name="siup" id="siup"
                                                       value="<?= isset($_POST['siup']) ? $_POST['siup'] : '' ?>"
                                                       placeholder="SIUP" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Upload SIUP</label>
                                                <input type="file" class="form-control" name="file_siup" id="file_siup"
                                                       value=""
                                                       placeholder="Upload SIUP" required
                                                       accept="image/*, application/pdf">
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
    $(function () {
    });
</script>