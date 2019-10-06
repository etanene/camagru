<?php

class CommentController extends Controller {
    public function __construct() {
        $this->model = new Comment();
    }

    public function add() {
        $resolve = [];

        if (!Session::get('logged')) {
            $resolve['message'] = 'Log in to like or comment photo!';
        } else if ($_POST && isset($_POST['comment']) && isset($_POST['image']) && isset($_POST['user'])) {
            $date = new DateTime();
            $this->model->addCommentToImage($_POST['comment'], $_POST['image'], $_POST['user'], $date->format('Y-m-d H:i:s'));
            $resolve['date'] = $date->format('Y-m-d H:i:s');
        }
        exit(json_encode($resolve));
    }
}
