<?php

class Insert {

    private $row;
    private $value;

    public function __construct($row, $value) {
        $this->row = $row;
        $this->value = $value;
    }

    public function getRow() {
        return $this->row;
    }

    public function getValue()
    {
        return $this->value;
    }
}