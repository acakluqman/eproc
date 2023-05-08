<?php
// simpan data vendor
if (isset($_POST['vendor'])) {


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