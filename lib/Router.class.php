<?php

class Router {
	private $uri;
	private $controller = 'main';
	private $action = 'index';
	private $params = [];

	public function __construct($uri) {
		$this->uri = trim($uri, '/');

		$uri_parts = explode('?', $this->uri);
		$uri_parts = explode('/', $uri_parts[0]);
		if ($uri_parts[0]) {
			$this->controller = $uri_parts[0];
		}
		if (isset($uri_parts[1])) {
			$this->action = $uri_parts[1];
		}
		if (isset($uri_parts[2])) {
			$this->params = array_slice($uri_parts, 2);
		}
		
		// if (current($uri_parts)) {
		// 	$this->controller = current($uri_parts);
		// 	next($uri_parts);
		// }
		// if (current($uri_parts)) {
		// 	$this->action = current($uri_parts);
		// 	next($uri_parts);
		// }
		// if (current($uri_parts) || current($uri_parts) == '0' ) {
		// 	$this->params = array_slice($uri_parts, 2);
		// }
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
