<?php

require "../php/database/DatabaseAdapter.php";

class App
{


    /**
     * @param $token
     * @param $email
     * @return bool|null
     */
    public static function validateKey($token, $email)
    {
        $db = new DatabaseAdapter();
        if ($db->containsEntry("access_tokens", new Key("email", $email), new Key("token", $token))) {
            return true;
        } else {
            if ($db->containsEntry("access_tokens", new Key("email", $email))) {
                return false;
            } else {
                return null;
            }
        }
    }

    public static function login($email, $password)
    {
        $db = new DatabaseAdapter();
        if (!$db->containsEntry("users", new Key("email", $email))) {
            return "WRONG_LOGIN";
        }

        if (!password_verify($password, $db->getStringFromTable("users", "password", new Key("email", $email)))) {
            return "WRONG_LOGIN";
        }

        if ($db->getIntegerFromTable("users", "permitted", new Key("email", $email)) == 0) {
            return "NOT_PERMITTED";
        }

        return self::newToken($email);
    }

    public static function printError($errorMessage)
    {
        $json = array("error" => $errorMessage);
        echo json_encode($json);
    }

    public static function getTasks($email)
    {
        $db = new DatabaseAdapter();
        if ($db->getIntegerFromTable("users", "isBms", new Key("email", $email)) == 1) {
            $isBms = true;
        } else
            $isBms = false;
        $json = $db->getAllStringsFromTable("tasks", "date");

        $newJson = array();
        foreach ($json as $key => $item) {
            if ($item['date'] > time()) {
                if ($item['category'] == "BMS" && $isBms) {
                    array_push($newJson, $item);
                } elseif ($item['category'] == "TBZ") {
                    array_push($newJson, $item);
                }
            }
        }
        $json = $newJson;

        return json_encode($json);
    }

    private static function newToken($email)
    {
        $token = self::generateToken();
        $db = new DatabaseAdapter();
        if ($db->containsEntry("access_tokens", new Key("email", $email))) {
            $db->updateValue("access_tokens", "token", $token, new Key("email", $email));
        } else {
            $db->insertIntoTable("access_tokens", new Insert("email", $email), new Insert("token", $token));
        }
        return $token;
    }

    private static function generateToken()
    {
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);
        return $token;
    }

}