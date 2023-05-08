<?php
require_once('./config.php');

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();

    header('Location:' . base_url());
}

if (isset($_SESSION['is_login']) && !isset($_GET['action'])) {
    header('Location:' . base_url());
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
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="login-logo mt-3">
                <img src="<?= base_url('dist/img/uwks.png') ?>" alt="Universitas Wijaya Kusuma Surabaya" height="80px">
            </div>

            <?php require_once('pages/auth/' . $_GET['page'] . '.php'); ?>
        </div>
    </div>

    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
</body>

</html>