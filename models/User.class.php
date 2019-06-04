<?php

class User extends Model {
    public function getAllUsers() {
        $result = $this->db->query('SELECT `login` FROM `users`')->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function getUserByLogin($login) {
        $sql = 'SELECT *
                FROM `users`
                WHERE `login` = :login;';
        
        $params = [
            'login' => $login
        ];
        
        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
    }

    public function getUserByEmail($email) {
        $sql = 'SELECT *
                FROM `users`
                WHERE `email` = :email;';

        $params = [
            'email' => $email
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
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
