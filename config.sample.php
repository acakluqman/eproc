<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Tamtamchik\SimpleFlash\Flash;
use PHPMailer\PHPMailer\PHPMailer;

ob_start();
if (!session_id()) session_start();

require_once('./config.php');
require_once('vendor/autoload.php');
require_once('function/general.php');

$flash = new Flash();
date_default_timezone_set('Asia/Jakarta');

// database
$db_host = '127.0.0.1';
$db_user = 'root';
$db_name = 'eproc';
$db_pass = 'hackyhack';     // rJkZ[-I+dTBK

// email
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
// $phpmailer->SMTPDebug = 2;
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = '9b469d6b6873c6';
$phpmailer->Password = 'abd847ae56dcc6';
$phpmailer->setFrom('noreply@eproc.test', 'eProcurement');

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
