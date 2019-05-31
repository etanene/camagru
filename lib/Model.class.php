<?php

class Model {
    protected $db;

    public function __construc() {
        $this->db = App::$db;
    }
}
