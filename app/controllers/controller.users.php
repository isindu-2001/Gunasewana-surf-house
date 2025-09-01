<?php


class users{
    private $user_email;
    private $user_id;
    private $admin_users = ["ganidu49@gmail.com", "admin@user.com"];
    
    public function __construct() {
        if ($this->isLogged()) {
            $this->user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
            $this->user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        } else {
            $this->user_email = null;
            $this->user_id = null;
        }
    }

    
    public function getUser($user_id) {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `users` WHERE `user_id` = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getAllUsers() {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `users`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isLogged(){
        return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'];
    }

    public function getUsername() {
        if ($this->isLogged()) {
            return $this->user_email;
        }
        return null;
    }

    public function getID() {
        if ($this->isLogged()) {
            return $this->user_id;
        }
        return null;
    }
    
    
    public function isAdmin() {
        if ($this->isLogged()) {
            return in_array($this->getUsername(), $this->admin_users);
        }
        return false;
    }

    
    public function updateUser($user_id, $firstName, $lastName, $email, $mobile) {
        $db = db();
        $stmt = $db->prepare("UPDATE `users` SET `user_firstName` = :firstName, `user_lastName` = :lastName, `user_email` = :email, `user_mobile` = :mobile WHERE `user_id` = :user_id");
        return $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'mobile' => $mobile, 'user_id' => $user_id]);
    }
    
    
    public function verifyPassword($user_id, $old_password) {
        $db = db();
        $stmt = $db->prepare("SELECT `user_password` FROM `users` WHERE `user_id` = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return password_verify($old_password, $user['user_password']);
    }

    
    
    public function updatePassword($user_id, $new_password) {
        $db = db();
        $stmt = $db->prepare("UPDATE `users` SET `user_password` = :new_password WHERE `user_id` = :user_id");
        return $stmt->execute(['new_password' => password_hash($new_password, PASSWORD_DEFAULT), 'user_id' => $user_id]);
    }
    
}