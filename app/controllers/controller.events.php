<?php 


class events {
    
    public static function fetchEvents() {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `events`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEvent($event_id) {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `events` WHERE `event_id` = :event_id");
        $stmt->execute(['event_id' => $event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        return $event ? $event : false;
    }

}