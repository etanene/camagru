<?php

class Comment extends Model {

    public function getCommentsByImage($image) {
        $sql = 'SELECT `text`, `users`.`login` as `user`, `images`.`createdDate` as `date`
                FROM `comments`
                INNER JOIN `images`
                    ON `comments`.`imageId` = `images`.`id`
                INNER JOIN `users`
                    ON `comments`.`userId` = `users`.`id`
                WHERE `images`.`image` = :image
                ORDER BY `images`.`createdDate` ASC;';
        
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
