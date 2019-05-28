<?php

class MainController extends Controller {
	public function index() {
		$this->data['content'] = 'index';
	}

	public function login() {
		$this->data['content'] = 'login';
	}
}
