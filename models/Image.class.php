<?php

class Image extends Model {

    public function getImageByName($name) {
        $sql = 'SELECT `image`, `login` as `user`
                FROM `images`
                INNER JOIN `users`
                    ON `images`.`loginId` = `users`.`id`
                WHERE `images`.`image` = :name;';
        
        $params = [
            'name' => $name
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
    }

    public function getAllImages() {
        $sql = 'SELECT `image`, `login` as `user`
                FROM `images`
                INNER JOIN `users`
                    ON `images`.`loginId` = `users`.`id`;';

        $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function getCountImages($last) {
        $sql = 'SELECT `images`.`id`, `image`, `login` as `user`
                FROM `images`
                INNER JOIN `users`
                    ON `images`.`loginId` = `users`.`id`
                WHERE `images`.`id` < :last
                ORDER BY `images`.`id` DESC, `images`.`createdDate` DESC
                LIMIT 6;';
        
        $params = [
            'last' => $last,
            // 'count' => $count
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function getCountImagesByUser($last, $user) {
        $sql = 'SELECT `images`.`id`, `image`, `login` as `user`
                FROM `images`
                INNER JOIN `users`
                    ON `images`.`loginId` = `users`.`id`
                WHERE `images`.`id` < :last AND `users`.`login` = :user
                ORDER BY `images`.`id` DESC, `images`.`createdDate` DESC
                LIMIT 6;';
        
        $params = [
            'last' => $last,
            'user' => $user
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function addImage($filename, $user) {
        $sql = 'INSERT INTO `images` (`image`, `loginId`)
                VALUES (:image, (
                    SELECT `id`
                    FROM `users`
                    WHERE `login` = :login)
                );';

        $params = [
            'image' => $filename,
            'login' => $user
        ];

        return ($this->db->query($sql, $params));
    }

    public function getImagesByUser($user) {
        $sql = 'SELECT `images`.`id`, `image`, `login` as `user`
                FROM `images`
                INNER JOIN `users`
                    ON `images`.`loginId` = `users`.`id`
                WHERE `users`.`login` = :login
                ORDER BY `images`.`createdDate` DESC;';
        
        $params = [
            'login' => $user
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function delImageByName($image) {
        $sql = 'DELETE
                FROM `images`
                WHERE `image` = :image;';

        $params = [
            'image' => $image
        ];

        return($this->db->query($sql, $params));
    }
}
