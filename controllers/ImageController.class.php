<?php

class ImageController extends Controller {

    private $comments;
    
    public function __construct() {
        parent::__construct();
        $this->model = new Image();
        $this->comments = new Comment();
    }

    public function show() {
        $this->data['author'] = $this->params[0];
        $this->data['name'] = $this->params[1];
        $this->data['comments'] = $this->comments->getCommentsByImage($this->params[1]);
    }

    public function add() {
        if (!Session::get('logged')) {
            App::redirect('/user/login');
            exit();
        }
        if ($_FILES) {
            $dir = ROOT . '/public/img/';
            $extension = explode('.', $_FILES['image']['name']);
            $filename = uniqid() . '.' . $extension[count($extension) - 1];
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . $filename);
            $this->model->addImage($filename, Session::get('logged'));
        }
    }
}
