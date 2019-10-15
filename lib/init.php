<?php

spl_autoload_register(function ($class) {
	$controller_path = ROOT . '/controllers/' . $class . '.class.php';
	$model_path = ROOT . '/models/' . $class . '.class.php';
	$lib_path = ROOT . '/lib/' . $class . '.class.php';

	if (file_exists($controller_path)) {
		require_once($controller_path);
	} else if (file_exists($model_path)) {
		require_once($model_path);
	} else if (file_exists($lib_path)) {
		require_once($lib_path);
	} else {
		header('HTTP/1.1 404 Not Found');
		include '404.php';
		exit();
	}
});

require_once('config.php');
