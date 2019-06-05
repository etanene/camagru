<?php

class ImageController extends Controller {
    public function __construct() {
        $this->model = new Image();
    }

    public function show() {
        $this->data['images'] = $this->model->getAllImages();
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
