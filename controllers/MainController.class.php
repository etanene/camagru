<?php

class MainController extends Controller {

	public function __construct() {
		$this->model = new User();
	}

	public function index() {
		$this->data['users'] = $this->model->getAllUsers();
	}
}
