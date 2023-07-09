<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?php if ($_SESSION['jenis_user'] == 3 && is_null($_SESSION['id_vendor'])): ?>
        <div class="alert alert-warning" role="alert">
            <p><strong>Pendaftaran Belum Lengkap</strong></p>
            <p class="mb-0">Silahkan lengkapi data perusahaan agar dapat melakukan penawaran tender!</p>
            <p>Klik <a href="<?= base_url('app/profil') ?>" class="alert-link">disini</a> untuk melengkapi data perusahaan
                Anda!</p>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Title</h3>
        </div>
        <div class="card-body">
            <p>Content</p>
        </div>
    </div>
</section>