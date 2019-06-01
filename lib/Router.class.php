<?php

class Router {
	private $uri;
	private $controller = 'main';
	private $action = 'index';
	private $params = [];

	public function __construct($uri) {
		$this->uri = trim($uri, '/');

		$uri_parts = explode('/', $this->uri);
		if (current($uri_parts)) {
			$this->controller = current($uri_parts);
			next($uri_parts);
		}
		if (current($uri_parts)) {
			$this->action = current($uri_parts);
			next($uri_parts);
		}
		if (current($uri_parts)) {
			$this->params = array_slice($uri_parts, 2);
		}
	}

	public function redirect($location) {
		header("Location: $location");
	}

	public function getController() {
		return ($this->controller);
	}

	public function getAction() {
		return ($this->action);
	}

	public function getParams() {
		return ($this->params);
	}
}
