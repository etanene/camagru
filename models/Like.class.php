<?php

class Like extends Model {

    public function getLikesCountByImage($image) {
        $sql = 'SELECT COUNT(*) as `count`
                FROM `likes`
                INNER JOIN `images`
                    ON `likes`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image;';

        $params = [
            'image' => $image
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
    }

    public function getLikesUsersByImage($image) {
        $sql = 'SELECT `users`.`login` as `user`
                FROM `likes`
                INNER JOIN `users`
                    ON `likes`.`userId` = `users`.`id`
                INNER JOIN `images`
                    ON `likes`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image;';

        $params = [
            'image' => $image
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function checkLikeUserImage($image, $user) {
        $sql = 'SELECT *
                FROM `likes`
                INNER JOIN `users`
                    ON `likes`.`userId` = `users`.`id`
                INNER JOIN `images`
                    ON `likes`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image AND `users`.`login` = :user;';
        
        $params = [
            'image' => $image,
            'user' => $user
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? false : true);
    }

    public function delLikeFromImage($image, $user) {
        $sql = 'DELETE `likes`.*
                FROM `likes`
                INNER JOIN `users`
                    ON `likes`.`userId` = `users`.`id`
                INNER JOIN `images`
                    ON `likes`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image AND `users`.`login` = :user;';
        
        $params = [
            'image' => $image,
            'user' => $user
        ];
        
        return ($this->db->query($sql, $params));
    }

    public function addLikeToImage($image, $user) {
        $sql = 'INSERT INTO `likes` (`imageId`, `userId`)
                VALUES ((
                    SELECT `id`
                    FROM `images`
                    WHERE `image` = :image
                ), (
                    SELECT `id`
                    FROM `users`
                    WHERE `login` = :user
                ));';
        
        $params = [
            'image' => $image,
            'user' => $user
        ];

        return ($this->db->query($sql, $params));
    }
}
