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

    public function getimages() {
        $count = $this->params[0];
        $last = $this->params[1];

        $images = $this->model->getCountImages($count, $last);
    }

    public function add() {
        
        if (!Session::get('logged')) {
            App::redirect('/user/login');
            exit();
        }

        if ($_FILES) {
            $resImg = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
            $stickers = json_decode($_POST['stickers'], true);
            
            foreach($stickers as $key => $stick) {
                $stickImg = imagecreatefromstring(file_get_contents(ROOT . '/public/img/sticker/' . $key));
                imagecopy($resImg, $stickImg, $stick['x'], $stick['y'], 0, 0, 128, 128);
            }

            $dir = ROOT . '/public/img/photo/';
            $filename = uniqid();
            imagepng($resImg, $dir . $filename);
            $this->model->addImage($filename, Session::get('logged'));
            exit();
        }
        $this->data['stickers'] = $this->stickers->getAllStickers();
    }

    public function test() {
        $json = file_get_contents('php://input');
        
        $arr = json_decode($json, true);
        exit();
    }
}
