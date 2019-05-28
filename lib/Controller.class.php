<?php

class Controller {
	private $data;
	private $model;
	private $params;

	public function __construct() {
		$this->params = App::getRouter()->getParams();
	}
}
