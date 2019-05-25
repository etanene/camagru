<?php

class Controller {
	private $data;
	private $model;
	private $params;

	public function __construct($data) {
		$this->data = $data;
		$this->params = App::getRouter()->getParams();
	}
}
