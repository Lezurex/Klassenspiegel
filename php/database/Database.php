<?php


class Database {
    public static $host = "localhost";
    public static $user = "root";
    public static $password = "";
    public static $port = 3306;
    public static $database = "klassenspiegel";
    public static $con;

    public static function connect() {
        self::$con = mysqli_connect(self::$host, self::$user, self::$password, self::$database);
    }

    public static function disconnect() {
        if(self::isConnected()) {
            mysqli_close(self::$con);
        }
    }

    public static function isConnected() {
        return self::$con != null;
    }

    public static function getConnection() {
        return self::$con;
    }

}