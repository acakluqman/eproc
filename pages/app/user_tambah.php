<?php
// ambil data satker dari db
$sqlSatker = $conn->prepare("SELECT * FROM satker ORDER BY nama ASC");
$sqlSatker->execute();
$satker = $sqlSatker->fetchAll();

if (isset($_POST['nama'])) {
    // cek email apakah sudah digunakan
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];
    $jenis_user = $_POST['jenis_user'];
    $tgl_daftar = date('Y-m-d H:i:s');

    $cekEmail = $conn->prepare("SELECT email FROM user WHERE email = :email");
    $cekEmail->execute(['email' => $email]);
    $user = $cekEmail->rowCount();

    // sudah ada user dengan email tersebut
    if ($user) {
        $flash->warning('Email sudah digunakan. Silahkan gunakan email yang lain!', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    } else {
        // validasi password
        if ($password == $konfirmasi) {
            $tambahUser = $conn->prepare("INSERT INTO user (nama, email, password, jenis_user, tgl_daftar) VALUES (:nama, :email, :password, :jenis_user, :tgl_daftar)");
            $tambahUser->execute(['nama' => $nama, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'jenis_user' => $jenis_user, 'tgl_daftar' => $tgl_daftar]);

            if ($tambahUser) {
                $flash->success('Berhasil tambah user!', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            } else {
                $flash->warning('Gagal menambahkan user. Silahkan ulangi kembali!', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }
        } else {
            // kombinasi password tidak cocok
            $flash->warning('Kombinasi password tidak cocok!', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <?php
                if ($_GET['id_jenis'] == 1) {
                    echo '<h1>Tambah Data Administrator</h1>';
                } elseif ($_GET['id_jenis'] == 2) {
                    echo '<h1>Tambah Data Petugas LPSE</h1>';
                } elseif ($_GET['id_jenis'] == 3) {
                    echo '<h1>Tambah Data Vendor Perusahaan</h1>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $flash->display() ?>
    <div class="card">
        <div class="card-body">
            <form action="" class="form-horizontal" method="post">
                <input type="hidden" name="jenis_user" value="<?= $_GET['id_jenis'] ?>" readonly>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Pengguna</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $_POST['nama'] ?: '' ?>" placeholder="Nama Pengguna" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" id="email" value="<?= $_POST['email'] ?: '' ?>" placeholder="Alamat Email" inputmode="email" required>
                    </div>
                </div>

                <?php if ($_GET['id_jenis'] == 2) : ?>
                    <div class="form-group row">
                        <label for="satker" class="col-sm-2 col-form-label">Satuan Kerja</label>
                        <div class="col-md-6">
                            <select class="form-control" name="satker" id="satker">
                                <?php foreach ($satker as $s) : ?>
                                    <option value="<?= $s['id_satker'] ?>"><?= $s['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                <?php endif ?>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="konfirmasi" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi Password" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-md-6">
                        <?php
                        if ($_GET['id_jenis'] == 1) {
                            echo '<a href="' . base_url('app/user/admin') . '" class="btn btn-danger"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>';
                        } elseif ($_GET['id_jenis'] == 2) {
                            echo '<a href="' . base_url('app/user/petugas') . '" class="btn btn-danger"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>';
                        } elseif ($_GET['id_jenis'] == 3) {
                            echo '<a href="' . base_url('app/user/vendor') . '" class="btn btn-danger"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>';
                        }
                        ?>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#satker').select2({
            theme: 'bootstrap4',
        });
    })
</script>