<?php


class Key {

    private $row;
    private $keyWord;

    public function __construct($row, $keyWord) {
        $this->row = $row;
        $this->keyWord = $keyWord;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function getKeyWord()
    {
        return $this->keyWord;
    }

}