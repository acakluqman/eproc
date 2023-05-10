<?php
// ambil data admin dari database
$sqlUser = $conn->prepare("SELECT u.*, v.nama as nama_pt, v.npwp FROM user u LEFT JOIN vendor v ON v.id_vendor = u.id_vendor WHERE md5(u.id_user) = :id_user ORDER BY u.nama ASC");
$sqlUser->execute(['id_user' => $_GET['id_user']]);
$user = $sqlUser->fetch();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <?php
                if ($_GET['id_jenis'] == 1) {
                    echo '<h1>Edit Data Administrator</h1>';
                } elseif ($_GET['id_jenis'] == 2) {
                    echo '<h1>Edit Data Petugas LPSE</h1>';
                } elseif ($_GET['id_jenis'] == 3) {
                    echo '<h1>Edit Data Vendor Perusahaan</h1>';
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
            <?php
            var_dump($user);
            ?>
        </div>
    </div>
</section>

<script>
    $(function() {

    })
</script>