<?php
class Database
{
    private static $dbHost = "db5017042589.hosting-data.io";
    private static $dbName = "dbs13718857";
    private static $dbUser = "dbu499225";
    private static $dbUserPassword = "Yoann110712@GestionBDD";

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