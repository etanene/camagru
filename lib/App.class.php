<?php

class App {
	private static $router;
	public static $db;

	public static function getRouter() {
		return (self::$router);
	}

	public static function run($uri) {
		self::$router = new Router($uri);
		self::$db = new Db(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_passwd'));

		$controller_class = ucfirst(self::$router->getController()) . 'Controller';
		$controller_method = self::$router->getAction();

		$controller = new $controller_class();
		if (method_exists($controller, $controller_method)) {
			$view_path = $controller->$controller_method();
			$view = new View($controller->getData(), $view_path);
			$content = $view->render();
		} else {
			throw new Exception('Method' . $controller_method . 'of class' . $controller_class . 'does not exist');
		}
		$layout = new View(compact('content'), ROOT . '/views/layout.php');
		echo $layout->render();
	}
}
