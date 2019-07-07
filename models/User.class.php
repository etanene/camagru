<?php

class User extends Model {
    public function getAllUsers() {
        $sql = 'SELECT `login`
                FROM `users`;';

        $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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

    public function activateUser($code) {
        $sql = 'UPDATE `users`
                SET `verified` = 1, `verification_code` = NULL
                WHERE `verification_code` = :code;';

        $params = [
            'code' => $code
        ];

        return ($this->db->query($sql, $params));
    }

    public function addUser($login, $password, $email, $code) {
        $sql = 'INSERT INTO `users` (`login`, `password`, `email`, `verification_code`)
                VALUES (:login, :password, :email, :code)';
        
        $params = [
            'login' => $login,
            'password' => $password,
            'email' => $email,
            'code' => $code
        ];

        return ($this->db->query($sql, $params));
    }
}
