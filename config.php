<?php
ob_start();
session_start();

$_SESSION['is_login'] = true;
$_SESSION['nama'] = 'Luqman Hakim';

$db_host = '127.0.0.1';
$db_user = 'root';
$db_name = 'eproc';
$db_pass = 'hackyhack';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
