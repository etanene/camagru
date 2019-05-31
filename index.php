<?php

define('ROOT', __DIR__);

require_once( ROOT . '/lib/init.php');

App::run($_SERVER['REQUEST_URI']);

$test = App::$db->query('SELECT * FROM users');

print_r($test);
