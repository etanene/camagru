<?php

define('ROOT', __DIR__);

require_once( ROOT . '/lib/init.php');

session_start();

App::run($_SERVER['REQUEST_URI']);
