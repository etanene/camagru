<?php

define('ROOT', __DIR__);

echo ROOT;

require_once('./lib/init.php');



$router = new Router($_SERVER['REQUEST_URI']);
