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
        `login` VARCHAR(16) NOT NULL,
        `email` VARCHAR(32) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `verified` TINYINT NOT NULL DEFAULT 0,
        `verification_code` VARCHAR(255) NOT NULL
    );';
    $dbh->exec($sql);
    echo 'Table users created' . PHP_EOL;

    $sql = 'CREATE TABLE IF NOT EXISTS ' . $DB_NAME . '.images (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `image` VARCHAR(64) NOT NULL,
        `loginId` INT UNSIGNED NOT NULL,
        `createdDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );';
    $dbh->exec($sql);
    echo 'Table images created' . PHP_EOL;

    $sql = 'CREATE TABLE IF NOT EXISTS ' . $DB_NAME . '.comments (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `text` VARCHAR(255) NOT NULL,
        `imageId` INT UNSIGNED NOT NULL,
        `userId` INT UNSIGNED NOT NULL,
        `createdDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );';
    $dbh->exec($sql);
    echo 'Table comments created' . PHP_EOL;

    $sql = 'CREATE TABLE IF NOT EXISTS ' . $DB_NAME . '.likes (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `imageId` INT UNSIGNED NOT NULL,
        `userId` INT UNSIGNED NOT NULL
    );';
    $dbh->exec($sql);
    echo 'Table likes created' . PHP_EOL;

    $sql = 'CREATE TABLE IF NOT EXISTS ' . $DB_NAME . '.stickers (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `image` VARCHAR(64) NOT NULL UNIQUE,
        `name` VARCHAR(64) NOT NULL
    );';
    $dbh->exec($sql);
    echo 'Table stickers created' . PHP_EOL;

    $sql = 'INSERT INTO ' . $DB_NAME . '.stickers (`image`, `name`)
            VALUES  ("1f4a9.png", "poo"),
                    ("1f60e.png", "sunglasses"),
                    ("1f926.png", "facepalm");';
    $dbh->exec($sql);
    echo 'Filled table stickers' . PHP_EOL;

} catch (PDOException $e) {
    echo 'Error!: ' . $e->getMessage() . PHP_EOL;
}
