<?php 


class rents {
    
    public static function fetchItems() {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `rent_items`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function getItem($item_id) {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `rent_items` WHERE `item_id` = :item_id");
        $stmt->execute(['item_id' => $item_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function cancelRent($request_id) {
        $db = db();
        $stmt = $db->prepare("UPDATE `rent_requests` SET `status` = 'cancelled' WHERE `request_id` = :request_id");
        return $stmt->execute(['request_id' => $request_id]);
    }

    public static function fetchMyRents() {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("SELECT * FROM `rent_requests` WHERE `user_id` = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function fetchAllRequests() {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `rent_requests`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}