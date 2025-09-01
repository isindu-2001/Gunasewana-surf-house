<?php 


class bookings {
    
    public static function fetchMyBookings() {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("SELECT * FROM `bookings_rooms` WHERE `user_id` = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchMyGardenBookings() {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("SELECT * FROM `bookings_garden` WHERE `user_id` = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function cancelBooking($id) {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("UPDATE `bookings_rooms` SET `booking_status` = 'cancelled' WHERE `booking_id` = :id AND `user_id` = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
    }

    public static function cancelGardenBooking($id) {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("UPDATE `bookings_garden` SET `booking_status` = 'cancelled' WHERE `booking_id` = :id AND `user_id` = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
    }

    
    public static function updateBookingDates($booking_id, $checkin, $checkout) {
        global $users;
        $db = db();

        $user_id = $users->getID();
        $stmt = $db->prepare("UPDATE `bookings_rooms` SET `checkin` = :checkin, `checkout` = :checkout WHERE `booking_id` = :id AND `user_id` = :user_id");
        return $stmt->execute(['id' => $booking_id, 'checkin' => $checkin, 'checkout' => $checkout, 'user_id' => $user_id]);
    }

}