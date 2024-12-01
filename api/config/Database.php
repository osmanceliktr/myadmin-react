<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=osmancelikdb", 'root', '00100');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec("SET NAMES utf8");
            } catch (PDOException $e) {
                die("Veritabanı bağlantı hatası: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
