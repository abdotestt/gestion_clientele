<?php
class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $dbname = 'client_management_db';
            $username = 'root';
            $password = '';
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            self::$pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
        
    }
}
?>
