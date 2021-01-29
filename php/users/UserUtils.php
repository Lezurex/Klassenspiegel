<?php

require_once "../config.php";
require_once "../database/DatabaseAdapter.php";

class UserUtils {

    var $db;

    public function __construct() {
        $this->db = new DatabaseAdapter();
    }

    function isInSchool($email, $school_name) {

    }

}