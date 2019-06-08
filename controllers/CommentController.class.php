<?php

class CommentController extends Controller {
    public function __construct() {
        $this->model = new Comment();
    }

    public function add() {
        if (!Session::get('logged')) {
            App::redirect('/user/login');
            exit();
        }
        if ($_POST && isset($_POST['comment']) && isset($_POST['image']) && isset($_POST['user'])) {
            $this->model->addCommentToImage($_POST['comment'], $_POST['image'], $_POST['user']);
            App::redirect('/image/show/' . $_POST['author'] . '/' . $_POST['image']);
            exit();
        }
    }
}
