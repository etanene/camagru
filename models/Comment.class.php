<?php

class Comment extends Model {

    public function getCommentsByImage($image) {
        $sql = 'SELECT `comments`.`id` as `id`, `text`, `users`.`login` as `user`, `comments`.`createdDate` as `date`
                FROM `comments`
                INNER JOIN `images`
                    ON `comments`.`imageId` = `images`.`id`
                INNER JOIN `users`
                    ON `comments`.`userId` = `users`.`id`
                WHERE `images`.`image` = :image
                ORDER BY `comments`.`createdDate` ASC;';
        
        $params = [
            'image' => $image
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function addCommentToImage($comment, $image, $user, $date = null) {
        $sql = 'INSERT INTO `comments` (`text`, `imageId`, `userId`, `createdDate`)
                VALUES (
                    :text,
                    (
                        SELECT `id`
                        FROM `images`
                        WHERE `image` = :image
                    ),
                    (
                        SELECT `id`
                        FROM `users`
                        WHERE `login` = :user
                    ),
                    :date
                );';

        $params = [
            'text' => $comment,
            'image' => $image,
            'user' => $user,
            'date' => $date
        ];

        return ($this->db->query($sql, $params));
    }

    public function delCommentFromImage($id) {
        $sql = 'DELETE
                FROM `comments`
                WHERE `id` = :id;';

        $params = [
            'id' => $id
        ];

        return ($this->db->query($sql, $params));
    }

    public function getCommentsCountByImage($image) {
        $sql = 'SELECT COUNT(*) as `count`
                FROM `comments`
                INNER JOIN `images`
                    ON `comments`.`imageId` = `images`.`id`
                WHERE `images`.`image` = :image;';

        $params = [
            'image' => $image
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
    }

    public function getCommentId($comment, $image, $user, $date) {
        $sql = 'SELECT `comments`.`id`
                FROM `comments`
                INNER JOIN `images`
                    ON `comments`.`imageId` = `images`.`id`
                INNER JOIN `users`
                    ON `comments`.`userId` = `users`.`id`
                WHERE `comments`.`text` = :comment
                    AND `images`.`image` = :image
                    AND `users`.`login` = :login
                    AND `comments`.`createdDate` = :date;';
                
        $params = [
            'comment' => $comment,
            'image' => $image,
            'login' => $user,
            'date' => $date
        ];

        $result = $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result[0]);
    }
}
