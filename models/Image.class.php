<?php

class Image extends Model {
    public function getAllImages() {
        $sql = 'SELECT `image`
                FROM `images`;';

        $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }

    public function addImage($filename, $user) {
        $sql = 'INSERT INTO `images` (`image`, `loginId`)
                VALUES (:image, (
                    SELECT `id`
                    FROM `users`
                    WHERE `login` = :login)
                )';

        $params = [
            'image' => $filename,
            'login' => $user
        ];

        return ($this->db->query($sql, $params));
    }
}
