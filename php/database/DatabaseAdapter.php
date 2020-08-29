<?php

require "Key.php";
require "Insert.php";
require "Row.php";
require "Database.php";

class DatabaseAdapter {

    public function __construct() {
        Database::connect();
    }

    /**
     * Create table in database
     *
     * @param String $name Name of the table to be created in the database specified in Database.php
     * @param Row ...$row Rows to be added to the table
     */

    public function createTable($name, ...$row) {
        $stringBuilder = "";
        $stringBuilder .= "CREATE TABLE IF NOT EXISTS {$name} (";

        $length = sizeof($row);

        foreach ($row as $rows) {
            $stringBuilder .= $rows->getName() . " ";
            $separator = "";
            if ($length == 1) {
                $separator = ", ";
                $length--;
            }
            switch ($rows->getType()) {
                case "VARCHAR":
                    $stringBuilder .= "varchar(250)".$separator;
                    break;
                case "INTEGER":
                    $stringBuilder .= "bigint(250)".$separator;
                    break;
                case "TEXT":
                    $stringBuilder .= "text".$separator;
                    break;
                case "DOUBLE":
                    $stringBuilder .= "double(250, 2)".$separator;
                    break;
            }
        }
        $stringBuilder .= ");";
        $this->executeCommand($stringBuilder);
    }

    /**
     * @param String $query Valid SQL query string
     * @return mixed 0 if not successful, default return value of mysqli_query() if successful
     */
    public function executeCommand($query) {
        try {
            return mysqli_query(Database::getConnection(), $query);
        }
        catch (mysqli_sql_exception $exception) {
            return 0;
        }
    }

    /**
     * @param $tablename
     * @param $row
     * @param Key ...$keys
     *
     * @return String|int Returns the searched string if successful, if not, it returns 0
     */
    public function getStringFromTable($tablename, $row, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "SELECT {$row} FROM {$tablename} ";
        $length = sizeof($keys);
        if($length != 0) {
            foreach($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND ";
                    $length--;
                }
            }
        }
        try {
            $result = mysqli_query(Database::getConnection(), $stringBuilder);
            while($returnRow = mysqli_fetch_assoc($result)) {
                return $returnRow[$row];
            }
        } catch (mysqli_sql_exception $exception) {}
        return 0;
    }

    /**
     * @param String $tablename
     * @param String $row
     * @param Key ...$keys
     *
     * @return array|int Returns the searched strings if successful, if not, it returns 0
     */
    public function getStringListFromTable($tablename, $row, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "SELECT {$row} FROM {$tablename} ";
        $length = sizeof($keys);
        if($length != 0) {
            foreach($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND ";
                    $length--;
                }
            }
        }
        try {
            $result = mysqli_query(Database::getConnection(), $stringBuilder);

            $results = array();
            while($returnRow = mysqli_fetch_assoc($result)) {
                array_push($results, $returnRow[$row]);
            }
            return $results;
        } catch (mysqli_sql_exception $exception) {}
        return 0;
    }

    /**
     * @param $tablename
     * @param $row
     * @param Key ...$keys
     *
     * @return null|int Returns an int if successful, if not, it returns null
     */
    public function getIntegerFromTable($tablename, $row, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "SELECT {$row} FROM {$tablename} ";
        $length = sizeof($keys);
        if($length != 0) {
            foreach($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND ";
                    $length--;
                }
            }
        }
        try {
            $result = mysqli_query(Database::getConnection(), $stringBuilder);
            while($returnRow = mysqli_fetch_assoc($result)) {
                return (int)$returnRow[$row];
            }
        } catch (mysqli_sql_exception $exception) {}
        return null;
    }


    /**
     * @param String $tablename
     * @param Insert ...$inserts
     * @return bool|mysqli_result raw mysqli_query() return value
     */
    public function insertIntoTable($tablename, ...$inserts) {
        $stringBuilder = "";
        $stringBuilder .= "INSERT INTO {$tablename} (";

        $length = sizeof($inserts);

        foreach ($inserts as $insert) {
            if($length != 0) {
                $stringBuilder .= $insert->getRow() . ", ";
                $length--;
            } else {
                $stringBuilder .= $insert->getRow();
            }
        }

        $stringBuilder .= ") VALUES (";
        $length = sizeof($inserts);

        foreach ($inserts as $insert) {
            if($length != 1) {
                $stringBuilder .= "'" . $insert->getValue() . "', ";
                $length--;
            } else {
                $stringBuilder .= "'" . $insert->getValue() . "'";
            }
        }
        $stringBuilder .= ");";
        return mysqli_query(Database::getConnection(), $stringBuilder);
    }

    /**
     * @param String $tablename
     * @param String $row
     * @param String $newValue
     * @param Key ...$keys
     * @return mixed mysqli_query() return value
     */
    public function updateValue($tablename, $row, $newValue, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "UPDATE {$tablename} SET {$row} = '{$newValue}' ";

        $length = sizeof($keys);
        if($length != 0) {
            foreach ($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND";
                    $length--;
                }
            }
        }
        return $this->executeCommand($stringBuilder);
    }

    /**
     * @param $tablename
     * @param Key $key
     * @param Insert ...$inserts
     * @return mixed mysqli_query() return value
     */
    public function updateValues($tablename, $key, ...$inserts) {
        $stringBuilder = "";
        $stringBuilder .= "UPDATE {$tablename} SET ";

        $length = sizeof($inserts);
        foreach ($inserts as $insert) {
            if($length == 1) {
                $stringBuilder .= $insert->getRow() . " = '" . $insert->getValue() . "' ";
            } else {
                $stringBuilder .= $insert->getRow() . " = '" . $insert->getValue() . "', ";
                $length--;
            }
        }
        $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";

        return $this->executeCommand($stringBuilder);
    }

    /**
     * @param $tablename
     * @param Key ...$keys
     * @return true|false
     */
    public function containsEntry($tablename, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "SELECT * FROM {$tablename} ";

        $length = sizeof($keys);

        if($length != 0) {
            foreach ($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= "WHERE " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND ";
                    $length--;
                }
            }
        }
        try {
            $result = mysqli_query(Database::getConnection(), $stringBuilder);
            if(mysqli_num_rows($result) == 0) {
                return false;
            } else
                return true;
        } catch (mysqli_sql_exception $exception) {

        }
        return false;
    }

    /**
     * @param String $tablename
     * @param Key ...$keys
     * @return mixed mysqli_query() return value
     */
    public function deleteFromTable($tablename, ...$keys) {
        $stringBuilder = "";
        $stringBuilder .= "DELETE FROM {$tablename} WHERE";

        $length = sizeof($keys);
        if($length != 0) {
            foreach ($keys as $key) {
                if($length == 1) {
                    $stringBuilder .= " " . $key->getRow() . " = '" . $key->getKeyWord() . "'";
                } else {
                    $stringBuilder .= " " . $key->getRow() . " = '" . $key->getKeyWord() . "' AND";
                    $length--;
                }
            }
        }
        return $this->executeCommand($stringBuilder);
    }

}