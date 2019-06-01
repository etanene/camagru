<?php

class User extends Model {
    public function getUsers() {
        $result = $this->db->query('SELECT `login` FROM users');
        return ($result);
    }

    public function getUser($login) {
        $sql = 'SELECT *
                FROM users
                WHERE `login` = :login;';
        
        $params = [
            'login' => $login
        ];

        return ($this->db->query($sql, $params));
    }
}
