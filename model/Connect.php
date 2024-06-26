<?php 

namespace Model;

// identification to database */
abstract class Connect {
    const HOST = "localhost";
    const DB = "cineBdd";
    const USER = "root";
    const PASS = "";

    public static function getPDO() {
        try {
            return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);
        } catch(\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}