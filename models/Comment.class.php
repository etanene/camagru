<?php

class Comment extends Model {

    public function getCommentsByImage($image) {
        $sql = 'SELECT *
                FROM `comments`
                INNER JOIN `images`
                    ON `comments`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image;';
        
        $params = [
            'image' => $image
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function addCommentToImage($comment, $image, $user) {
        $sql = 'INSERT INTO `comments` (`text`, `imageId`, `userId`)
                VALUES (:text, (
                    SELECT `id`
                    FROM `images`
                    WHERE `image` = :image
                ), (
                    SELECT `id`
                    FROM `users`
                    WHERE `login` = :user
                ));';

        $params = [
            'text' => $comment,
            'image' => $image,
            'user' => $user
        ];

        return ($this->db->query($sql, $params));
    }
}
