<?php

define('ROOT', __DIR__);

require_once( ROOT . '/lib/init.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Moscow');

session_start();

App::run($_SERVER['REQUEST_URI']);
