<?php

class MainController extends Controller {

	public function __construct() {
		$this->model = new Image();
	}

	public function index() {
		// $this->data['users'] = $this->model->getAllUsers();
		// $this->data['images'] = $this->model->getAllImages();
	}
}
