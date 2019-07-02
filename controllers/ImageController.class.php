<?php

class ImageController extends Controller {

    private $comments;
    private $likes;
    
    public function __construct() {
        parent::__construct();
        $this->model = new Image();
        $this->comments = new Comment();
        $this->likes = new Like();
        $this->stickers = new Sticker();
    }

    public function show() {
        $this->data['author'] = $this->params[0];
        $this->data['name'] = $this->params[1];
        $this->data['likes'] = $this->likes->getLikesCountByImage($this->params[1]);
        $this->data['comments'] = $this->comments->getCommentsByImage($this->params[1]);
    }

    public function add() {
        
        if (!Session::get('logged')) {
            App::redirect('/user/login');
            exit();
        }
        if ($_FILES) {
            $dir = ROOT . '/public/img/photo/';
            $filename = uniqid();
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . $filename);
            $this->model->addImage($filename, Session::get('logged'));
        }
        $this->data['stickers'] = $this->stickers->getAllStickers();
    }
}
