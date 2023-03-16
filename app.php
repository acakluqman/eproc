<?php
require_once('./config.php');

if (!isset($_SESSION['is_login'])) {
    header('Location:' . base_url('auth/login'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eProcurement &bullet; Universitas Wijaya Kusuma Surabaya</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/filepond@4.30.4/dist/filepond.css">
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">

    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop@2.0.6/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform@3.8.7/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" aria-label="nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="<?= base_url('app/profil') ?>" class="nav-link">
                        <img src="<?= base_url('dist/img/user2-160x160.jpg') ?>" class="user-image img-circle" alt="<?= $_SESSION['nama'] ?>">
                        <span class="d-none d-md-inline"><?= $_SESSION['nama'] ?></span>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?= base_url('app/dashboard') ?>" class="brand-link">
                <img src="<?= base_url('dist/img/uwks.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle">
                <span class="brand-text font-weight-light">eProcurement</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION['nama'] ?></a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2" aria-label="nav">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url('app/dashboard') ?>" class="nav-link <?= $_GET['page'] == 'dashboard' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>DASHBOARD</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('app/tender') ?>" class="nav-link <?= in_array($_GET['page'], ['tender', 'tender_detail']) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-gavel"></i>
                                <p>DATA TENDER</p>
                            </a>
                        </li>

                        <?php if ($_SESSION['jenis_user'] == 1) : ?>
                            <li class="nav-item <?= (isset($_GET['page']) && $_GET['page'] == 'user') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'user') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        DATA PENGGUNA
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('app/user/admin') ?>" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'user' && $_GET['id_jenis'] == 1) ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Administrator</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('app/user/petugas') ?>" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'user' && $_GET['id_jenis'] == 2) ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Petugas LPSE</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('app/user/vendor') ?>" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'user' && $_GET['id_jenis'] == 3) ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Vendor</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>LOGOUT</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
            if (isset($_GET['page']) && file_exists('./pages/app/' . $_GET['page'] . '.php')) {
                require_once('./pages/app/' . $_GET['page'] . '.php');
            } else {
            }
            ?>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                eProcurement
            </div>
            <strong>&copy; <?= date('Y') ?> <a href="https://www.uwks.ac.id/">Universitas Wijaya Kusuma Surabaya</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
</body>

</html>