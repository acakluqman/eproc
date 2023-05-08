<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Blank Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol>
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
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <div class="card-footer">
                Footer
            </div>
        </div>
    </div>
</section>