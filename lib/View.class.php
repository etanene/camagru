<?php

class View {
	private $view;
	private $data;

	public function __construct($data = array(), $view = null) {
		if (!$view) {
			$router = App::getRouter();
			$controller = $router->getController();
			$view = ROOT . '/views/' . $controller . '/' . $router->getAction() . '.php';
		}
		if (!file_exists($view)) {
			throw new Exception('Template not found' . $view);
		}
		$this->view = $view;
		$this->data = $data;
	}

	public function render() {
		$data = $this->data;
	
		ob_start();
		include($this->view);
		return (ob_get_clean());
	}
}
