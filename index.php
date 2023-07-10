<?php
require_once('./config.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eProcurement &bullet; Universitas Wijaya Kusuma Surabaya</title>
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">

    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <img src="<?= base_url('dist/img/uwks.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8">
                    <span class="brand-text font-weight-light">eProcurement</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item <?= !isset($_GET['page']) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>" class="nav-link">Beranda</a>
                        </li>
                        <li class="nav-item <?= isset($_GET['page']) && in_array($_GET['page'], ['tender', 'tender_detail']) ? 'active' : '' ?>">
                            <a href="<?= base_url('tender') ?>" class="nav-link">Tender</a>
                        </li>
                        <?php if (isset($_SESSION['is_login'])) : ?>
                            <li class="nav-item dropdown <?= in_array($_GET['page'], ['profil', 'penawaran']) ? 'active' : '' ?>">
                                <a id="dropdownUser" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Hi, <?= $_SESSION['nama'] ?></a>
                                <ul aria-labelledby="dropdownUser" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a href="<?= base_url('app/dashboard') ?>" class="dropdown-item">
                                            Dashboard
                                        </a>
                                    </li>
                                    <?php if ($_SESSION['jenis_user'] == 3) : ?>
                                        <li>
                                            <a href="<?= base_url('app/penawaran') ?>" class="dropdown-item">
                                                Penawaran Saya
                                            </a>
                                        </li>
                                    <?php elseif ($_SESSION['jenis_user'] == 2) : ?>
                                        <li>
                                            <a href="<?= base_url('app/tender/tambah') ?>" class="dropdown-item">
                                                Buat Tender Baru
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?= base_url('app/profil') ?>" class="dropdown-item">
                                            Profil Saya
                                        </a>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('auth/register') ?>" class="nav-link">
                                    Pendaftaran Rekanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('auth/login') ?>" class="nav-link">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <?php
            if (isset($_GET['page']) && file_exists('./pages/' . $_GET['page'] . '.php')) {
                require_once('./pages/' . $_GET['page'] . '.php');
            } else {
            }
            ?>
        </div>
    </div>

    <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
</body>

</html>