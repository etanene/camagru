<?php

class User extends Model {
    public function getAllUsers() {
        $result = $this->db->query('SELECT `login` FROM `users`');
        return ($result);
    }

    public function getUserByLogin($login) {
        $sql = 'SELECT *
                FROM `users`
                WHERE `login` = :login;';
        
        $params = [
            'login' => $login
        ];
        
        $result = $this->db->query($sql, $params);
        return (isset($result) ? $result[0] : null);
    }

    public function getUserByEmail($email) {
        $sql = 'SELECT *
                FROM `users`
                WHERE `email` = :email;';

        $params = [
            'email' => $email
        ];

        $result = $this->db->query($sql, $params);
        return (isset($result) ? $result[0] : null);
    }

    public function addUser($login, $password, $email) {
        $sql = 'INSERT INTO `users` (`login`, `password`, `email`)
                VALUES (:login, :password, :email)';
        
        $params = [
            'login' => $login,
            'password' => $password,
            'email' => $email
        ];

        return ($this->db->query($sql, $params));
    }
}
