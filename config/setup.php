<?php

require_once('./database.php');

try {
    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'CREATE DATABASE IF NOT EXISTS ' . $DB_NAME . ';';
    $dbh->exec($sql);
    echo 'Database ' . $DB_NAME . ' created' . PHP_EOL;
    $sql = 'CREATE TABLE IF NOT EXISTS ' . $DB_NAME . '.users (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `login` VARCHAR(8) NOT NULL,
        `email` VARCHAR(32) NOT NULL,
        `password` VARCHAR(32) NOT NULL
    );';
    $dbh->exec($sql);
    echo 'Table users created' . PHP_EOL;
} catch (PDOException $e) {
    echo 'Error!: ' . $e->getMessage() . PHP_EOL;
}
