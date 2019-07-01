<?php

class Sticker extends Model {
    public function getAllStickers() {
        $sql = 'SELECT *
                FROM `stickers`';

        $result = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result) ? null : $result);
    }
}
