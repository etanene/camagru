<?php

class DB {
    private $dbh;

    public function __construct($dsn, $user, $passwd) {
        $this->dbh = new PDO($dsn, $user, $passwd);
        echo "OK connect db" . PHP_EOL;
    }
}
