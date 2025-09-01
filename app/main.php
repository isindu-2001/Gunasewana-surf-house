<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_SERVER', '142.91.102.107');
define('DB_USER', 'sysadmin_sliitppa');
define('DB_PASS', 'Sliitppa@2025');
define('DB_NAME', 'sysadmin_sliitppa');
date_default_timezone_set("Asia/Colombo");


$scriptName = $_SERVER['SCRIPT_NAME'];
$scriptName = basename($scriptName);

if (strpos($scriptName, 'action') === 0) {
} else {
    $token = bin2hex(random_bytes(8));
    $_SESSION['token'] = $token;
}

$SITE_URL_SELF = $_SERVER['REQUEST_URI'];
$ENV_NAME = "Development";

// Utils
include 'functions.php';

// Controllers
include 'controllers/controller.users.php';
include 'controllers/controller.packages.php';
include 'controllers/controller.bookings.php';
include 'controllers/controller.events.php';
include 'controllers/controller.rents.php';

// Services

// Declarations
$users = new users;
$packages = new packages;
$bookings = new bookings;
$events = new events;
$rents = new rents;

if (strpos($SITE_URL_SELF, '/admin/') !== false) {
    if(!$users->isAdmin()) {
        die("Not Allowed");
    }
}
