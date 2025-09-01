<?php
// This file assumes session has already been started in main.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure $_SESSION is available in this scope
    if (!isset($_SESSION)) {
        global $_SESSION;
    }

    if (isset($_POST['token'], $_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
        if($ENV_NAME != "Development") {
            unset($_SESSION['token']);
        } 
    } else {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;   
}
