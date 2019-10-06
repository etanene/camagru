<?php

class LikeController extends Controller {

    public function __construct() {
        $this->model = new Like();
    }

    public function submit() {
        $resolve = [];

        if (Session::get('logged') && $_POST && isset($_POST['image']) && isset($_POST['user'])) {
            if ($this->model->checkLikeUserImage($_POST['image'], $_POST['user'])) {
                $this->model->delLikeFromImage($_POST['image'], $_POST['user']);
                $resolve['like'] = -1;
            } else {
                $this->model->addLikeToImage($_POST['image'], $_POST['user']);
                $resolve['like'] = 1;
            }
        } else {
            $resolve['message'] = 'Log in to like or comment photo!';            
        }
        exit(json_encode($resolve));
    }
}
