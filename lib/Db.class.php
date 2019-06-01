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
                $this->db->bindValue(':' . $key, $value);
            }
        }

        if ($result->execute()) {
            return ($result->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return (null);
        }
    }
}
