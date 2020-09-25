<?php


class Database {
    public static $host = "192.168.1.150";
    public static $port = 3306;
    public static $database = "klassenspiegel";
    public static $con;

    /*
     * Connects to the database with credentials from database.json
     */
    public static function connect() {
        $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/../database.json"), true);
        self::$con = mysqli_connect(self::$host, $json['username'], $json['password'], self::$database);
        self::$con->set_charset("utf8");
    }

    public static function disconnect() {
        if(self::isConnected()) {
            mysqli_close(self::$con);
        }
    }

    public static function isConnected() {
        return self::$con != null;
    }

    /**
     * @return mysqli connection
     */
    public static function getConnection() {
        return self::$con;
    }

}