<?php

include "../main.php"; 
include_once "../services/services.tokenMiddleware.php";

$db = db();

$first_name = postData('first_name');
$last_name = postData('last_name');
$mobile_number = postData('mobile_number');
$email = postData('email');
$password = postData('password');
$confirm_password = postData('confirm_password');

if(empty($first_name) || empty($last_name) || empty($mobile_number) || empty($email) || empty($password) || empty($confirm_password)) {
    redirect('../../login.php?error=All fields are required&type=error');
    exit;
}

if($password != $confirm_password) {
    redirect('../../login.php?error=Password does not match&type=error');
    exit;
}

$stmt = $db->prepare("SELECT * FROM `users` WHERE `user_email` = :email LIMIT 1");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    redirect('../../login.php?error=Account already exists with this email&type=error');
    exit;
}

$stmt = $db->prepare("INSERT INTO `users`(`user_firstName`, `user_lastName`, `user_email`, `user_mobile`, `user_password`) VALUES (:first_name, :last_name, :email, :mobile_number, :password)");
if ($stmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'mobile_number' => $mobile_number, 'password' => password_hash($password, PASSWORD_DEFAULT)])) {
    redirect('../../login.php?error=Account created successfully&type=success');
} else {
    redirect('../../login.php?error=Failed to create account&type=error');
}
