<?php

class App {
	private static $router;

	public static function getRouter() {
		return (self::$router);
	}

	public static function run($uri) {
		self::$router = new Router($uri);

		$controller_class = ucfirst(self::$router->getController()) . 'Controller';
		$controller_method = self::$router->getAction();

		$controller = new $controller_class();
		if (method_exists($controller, $controller_method)) {
			$controller->$controller_method();
		} else {
			throw new Exception('Method' . $controller_method . 'of class' . $controller_class . 'does not exist');
		}
	}
}
