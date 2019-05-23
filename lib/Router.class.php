<?php

class Router {
	private $uri;
	private $controller;
	private $action;
	private $params = [];

	public function __constructor($uri) {
		print_r('Uri: ' . $uri);
	}
}
