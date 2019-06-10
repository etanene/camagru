<?php

class LikeController extends Controller {

    public function __construct() {
        $this->model = new Like();
    }

    public function submit() {
        if ($_POST && isset($_POST['image']) && isset($_POST['user'])) {
            if ($this->model->checkLikeUserImage($_POST['image'], $_POST['user'])) {
                $this->model->delLikeFromImage($_POST['image'], $_POST['user']);
            } else {
                $this->model->addLikeToImage($_POST['image'], $_POST['user']);
            }
        }
        App::redirect($_SERVER['HTTP_REFERER']);
    }
}
