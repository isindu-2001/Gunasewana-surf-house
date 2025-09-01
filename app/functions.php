<?php


function db() {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function db_connect() {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


function postData($data) {
    if (empty($_POST[$data])) {
        return "";
    }
    return htmlspecialchars($_POST[$data], ENT_QUOTES, 'UTF-8');
}

function getData($data) {
    if (empty($_GET[$data])) {
        return "";
    }
    return htmlspecialchars($_GET[$data], ENT_QUOTES, 'UTF-8'); 
}


function redirect($url)
{
    echo "<script>window.location.href = '$url';</script>";
    die();
}

function getIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

function currentDatenTime(){
    $data = date('Y-m-d H:i');
    return "$data";
}

function currentDate(){
    $data = date('Y-m-d');
    return "$data";
}

function getRandomStringRandomInt($length = 35){
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pieces = [];
    $max = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++ $i) {
        $pieces[] = $stringSpace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function getRandomInt($length){
    $stringSpace = '0123456789';
    $pieces = [];
    $max = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++ $i) {
        $pieces[] = $stringSpace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function IPProtection(){
    $allowedIPs = array(
        '51.79.144.125',
        '139.99.120.96',
    );
    
    $clientIP = $_SERVER['REMOTE_ADDR'];
    
    if (!in_array($clientIP, $allowedIPs)) {
        header('HTTP/1.1 403 Forbidden');
        exit('Access Forbidden');
    } 
}

function fullError($msg){
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .full-screen-alert {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgba(0, 0, 0, 0.8);
                color: white;
                z-index: 1050;
            }
        </style>
    </head>
    <body>
        <!-- Full Screen Alert -->
        <div class="full-screen-alert">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error</h4>
                <p>'.$msg.'</p>
                <hr>
                <p class="mb-0">Please contact support if the problem persists.</p>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    </body>
    </html>
    ';
    exit();
}

function getDominantColor($imagePath) {
    if (!file_exists($imagePath)) {
        return '#000000';
    }

    $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($imagePath);
            break;
        case 'png':
            $image = imagecreatefrompng($imagePath);
            break;
        case 'gif':
            $image = imagecreatefromgif($imagePath);
            break;
        default:
            return '#000000';
    }

    $resizedImage = imagecreatetruecolor(1, 1);
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));

    $rgb = imagecolorat($resizedImage, 0, 0);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    $hex = sprintf("#%02x%02x%02x", $r, $g, $b);

    imagedestroy($image);
    imagedestroy($resizedImage);

    return $hex;
}

