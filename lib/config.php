<?php

include_once(ROOT . '/config/database.php');

Config::set('title', 'Camagru');

Config::set('db_dsn', $DB_DSN . ';dbname=' . $DB_NAME);
Config::set('db_user', $DB_USER);
Config::set('db_passwd', $DB_PASSWORD);
