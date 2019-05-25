<?php

define('ROOT', __DIR__);

require_once('./lib/init.php');

$router = new Router($_SERVER['REQUEST_URI']);

// echo $_SERVER['REQUEST_URI'];