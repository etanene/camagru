<?php

define('ROOT', __DIR__);

require_once('./lib/init.php');

App::run($_SERVER['REQUEST_URI']);