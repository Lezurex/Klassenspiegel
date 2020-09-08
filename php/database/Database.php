<?php


class Database {
    public static $host = "localhost"; //"192.168.1.150";
    public static $user = "root"; //"ap20b";
    public static $password = ""; //"Ru0ZRr*Q903!";
    public static $port = 3306;
    public static $database = "klassenspiegel";
    public static $con;

    public static function connect() {
        self::$con = mysqli_connect(self::$host, self::$user, self::$password, self::$database);
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

    public static function getConnection() {
        return self::$con;
    }

}