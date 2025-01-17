<?php
class Database
{
    private static $dbHost = "localhost";
    private static $dbName = "burger_code";
    private static $dbUser = "priscilla";
    private static $dbUserPassword = "Yoann110712@$";

    private static $connection = null;

    public static function connect()
    {
        try {
            self::$connection = new PDO(
                "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8",
                self::$dbUser,
                self::$dbUserPassword
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('ERROR:' . $e->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}

Database::connect();
?>