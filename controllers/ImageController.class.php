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
        $this->data['comments'] = $this->comments->getCommentsCountByImage($this->params[1]);
    }

    public function get() {
        $last = isset($this->params[0]) ? $this->params[0] : PHP_INT_MAX;
        // $count = isset($this->params[1]) ? $this->params[1] : 9;

        $images = $this->model->getCountImages($last);
        exit(json_encode($images));
    }

    public function add() {
        
        if (!Session::get('logged')) {
            App::redirect('/user/login');
            exit();
        }

        if ($_FILES) {
            $resolve = [];
            $stickers = [];
            $resImg = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
            if (isset($_POST['stickers'])) {
                $stickers = json_decode($_POST['stickers'], true);
            }
            
            foreach($stickers as $key => $stick) {
                $stickImg = imagecreatefromstring(file_get_contents(ROOT . '/public/img/sticker/' . $key));
                imagecopy($resImg, $stickImg, $stick['x'], $stick['y'], 0, 0, 128, 128);
            }

            $dir = ROOT . '/public/img/photo/';
            $filename = uniqid();
            imagepng($resImg, $dir . $filename);
            $this->model->addImage($filename, Session::get('logged'));
            $resolve['imageName'] = $filename;
            $resolve['user'] = Session::get('logged');
            exit(json_encode($resolve));
        }
        $this->data['stickers'] = $this->stickers->getAllStickers();
    }

    public function del() {
        $resolve = [];

        if (!Session::get('logged') || !isset($this->params[0])) {
            $resolve['message'] = 'Error';
        } else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->model->delImageByName($this->params[0]);
        }
        exit(json_encode($resolve));
    }

    public function getUserImages() {
        $resolve = [];
        if (isset($this->params[0])) {
            $images = $this->model->getImagesByUser($this->params[0]);
            $resolve = $images;
        }
        exit(json_encode($resolve));
    }
}
