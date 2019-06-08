<?php

class Like extends Model {

    public function getLikesCountByImage($image) {
        $sql = 'SELECT COUNT(*) as `countLikes`
                FROM `likes`
                INNER JOIN `images`
                    ON `likes`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image;';

        $params = [
            'image' => $image
        ];

        $result = $this->db->query();
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
