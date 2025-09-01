<?php

include "../main.php"; 
include_once "../services/services.tokenMiddleware.php";

$db = db();

$email = postData('email');
$password = postData('password');

if(empty($email) || empty($password)) {
    redirect('../../login.php?error=Email and password required&type=error');
}

$stmt = $db->prepare("SELECT * FROM `users` WHERE `user_email` = :user_email LIMIT 1");
$stmt->execute(['user_email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['user_password'])) {
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['user_email'] = $user['user_email'];
    $_SESSION['user_id'] = $user['user_id'];

    redirect('../../index.php?type=success&error=Logged in successfully');
} else {
    redirect('../../login.php?error=Invalid email or password&type=error');
}
