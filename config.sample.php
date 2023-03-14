<?php

use Tamtamchik\SimpleFlash\Flash;

ob_start();
if (!session_id()) {
    session_start();
}

require_once('./config.php');
require_once('vendor/autoload.php');
require_once('function/general.php');

$flash = new Flash();

$_SESSION['is_login'] = true;
$_SESSION['nama'] = 'Luqman Hakim';

$db_host = '127.0.0.1';     // localhost
$db_user = 'root';          // luqmanga_eproc
$db_name = 'eproc';         // luqmanga_eproc
$db_pass = 'hackyhack';     // rJkZ[-I+dTBK

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
