<?php

class DB {
    private $db;

    public function __construct($dsn, $user, $passwd) {
        $this->db = new PDO($dsn, $user, $passwd);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = []) {
        $result = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach($params as $key => $value) {
                $result->bindValue(':' . $key, $value);
            }
        }

        $result->execute();
        return ($result);
    }
}
