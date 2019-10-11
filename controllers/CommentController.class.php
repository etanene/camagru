<?php

class CommentController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Comment();
        $this->user = new User();
    }

    public function add() {
        $resolve = [];

        if (!Session::get('logged')) {
            $resolve['message'] = 'Log in to like or comment photo!';
        } else if ($_POST && isset($_POST['comment']) && isset($_POST['image']) && isset($_POST['user']) && isset($_POST['author'])) {
            $date = new DateTime();
            $this->model->addCommentToImage($_POST['comment'], $_POST['image'], $_POST['user'], $date->format('Y-m-d H:i:s'));
            $author = $this->user->getUserByLogin($_POST['author']);
            if ($author['notice'] && $_POST['author'] != Session::get('logged')) {
                $this->sendCommentNotice($author['email'], $_POST['user'], $_POST['author'], $_POST['image']);
            }
            $resolve['date'] = $date->format('Y-m-d H:i:s');
        }
        exit(json_encode($resolve));
    }

    public function getCommentsImage() {
        $resolve = [];
        if (isset($this->params[0])) {
            $comments = $this->model->getCommentsByImage($this->params[0]);
            $resolve = $comments;
        }
        exit(json_encode($resolve));
    }

    public function del() {
        $resolve = [];

        if (!Session::get('logged') || !isset($this->params[0])) {
            $resolve['message'] = 'Error';
        } else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->model->delCommentFromImage($this->params[0]);
        }
        exit(json_encode($resolve));
    }

    private function sendCommentNotice($email, $commentUser, $author, $image) {
        $link = 'http://localhost:8080/image/show/' . $author . '/' . $image . '/';
        $subject = 'New comment on your image';
        $body = "
        You have new comment from " . $commentUser . " on your image:
            <a href='" . $link . "'>link to image</a>
        ";
        $headers = 'Content-type: text/html';
        $res = mail($email, $subject, $body, $headers);
    }
}
