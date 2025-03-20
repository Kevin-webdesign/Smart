<?php

class Database {
    private static $connection = null;

    // Adding getInstance method to maintain compatibility with the controller
    public static function getInstance() {
        return self::getConnection();  // Reuse the existing getConnection method
    }

    public static function getConnection() {
        if (self::$connection === null) {
            // $host = getenv('DB_HOST');
            // $db = getenv('DB_NAME');
            // $user = getenv('DB_USER');
            // $pass = getenv('DB_PASS');
            $host = 'localhost';  
            $db = 'everretreat_db';  
            $user = 'root'; 
            $pass = ''; 

            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$db", $user, "");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}
?>
