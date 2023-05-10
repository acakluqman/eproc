<?php
// ambil data admin dari database
$sqlAdmin = $conn->prepare("SELECT u.*, v.nama as nama_pt, v.npwp FROM user u LEFT JOIN vendor v ON v.id_vendor = u.id_vendor WHERE u.jenis_user = :jenis_user ORDER BY u.nama ASC");
$sqlAdmin->execute(['jenis_user' => $_GET['id_jenis']]);
$admin = $sqlAdmin->fetchAll();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <?php
                if ($_GET['id_jenis'] == 1) {
                    echo '<h1>Data Administrator</h1>';
                } elseif ($_GET['id_jenis'] == 2) {
                    echo '<h1>Data Petugas LPSE</h1>';
                } elseif ($_GET['id_jenis'] == 3) {
                    echo '<h1>Data Vendor Perusahaan</h1>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $flash->display() ?>
    <div class="card">
        <?php
        if ($_GET['id_jenis'] == 1) {
            echo '<div class="card-header"><h3 class="card-title"><a href="' . base_url('app/user/tambah-admin') . '" class="btn btn-primary"><i class="fas fa-plus-circle mr-2"></i>Tambah</a></h3></div>';
        } elseif ($_GET['id_jenis'] == 2) {
            echo '<div class="card-header"><h3 class="card-title"><a href="' . base_url('app/user/tambah-petugas') . '" class="btn btn-primary"><i class="fas fa-plus-circle mr-2"></i>Tambah</a></h3></div>';
        }
        ?>

        <div class="card-body">
            <table class="table table-striped" id="user">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <?php if ($_GET['id_jenis'] == 3) { ?>
                            <th>Nama Perusahaan</th>
                            <th>NPWP</th>
                        <?php } ?>
                        <th>Tanggal Bergabung</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($admin as $user) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ . "." ?></td>
                            <td><?= $user['nama'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <?php if ($_GET['id_jenis'] == 3) { ?>
                                <td><?= $user['nama_pt'] ?></td>
                                <td><?= $user['npwp'] ?></td>
                            <?php } ?>
                            <td><?= tanggal($user['tgl_daftar']) ?></td>
                            <td>
                                <a href="<?= base_url('app/user/edit/' . md5($user['id_user'])) ?>" class="btn btn-xs btn-success" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="<?= base_url('app/user/hapus/' . md5($user['id_user'])) ?>" class="btn btn-xs btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#user').DataTable({
            language: {
                processing: 'Loading...',
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
            columnDefs: [{
                targets: [-1],
                orderable: false
            }]
        });
    })
</script>