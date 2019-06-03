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

        if ($result->execute()) {
            $arr = $result->fetchAll(PDO::FETCH_ASSOC);
            if (empty($arr)) {
                return (null);
            } else {
                return ($arr);
            }
        } else {
            return (null);
        }
    }
}
