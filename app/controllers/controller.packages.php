<?php 


class packages {
    
    public static function fetchPackages() {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `packages`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function getPackage($package_id) {
        $db = db();
        $stmt = $db->prepare("SELECT * FROM `packages` WHERE `package_id` = :package_id");
        $stmt->execute(['package_id' => $package_id]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);
        return $package ? $package : null;
    }
}