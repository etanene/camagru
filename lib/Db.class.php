<?php

class DB {
    private $db;

    public function __construct($dsn, $user, $passwd) {
        $this->db = new PDO($dsn, $user, $passwd);
    }

    public function query($sql) {
        $result = $this->db->prepare($sql);
        $result->execute();
        return ($result->fetchAll());
    }
}
