<?php

use Dotenv\Dotenv;

session_start();

include dirname(__DIR__) . '/bootstrap/constants.php';
include ROOT_PATH . "vendor/autoload.php";
include ROOT_PATH . "libs/helpers.php";

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

$database_connection = (object)[
    "name" => $_ENV['DB_NAME'],
    "host" => $_ENV['DB_HOST'],
    "username" => $_ENV['DB_USER'],
    "password" => $_ENV['DB_PASS']
];

$dsn = "mysql:dbname=$database_connection->name;host=$database_connection->host";

try {
    $pdo = new PDO($dsn, $database_connection->username, $database_connection->password);
} catch (PDOException $e) {
    diePage($e);
}

include ROOT_PATH . "libs/lib-auth.php";
include ROOT_PATH . "libs/lib-folders.php";
include ROOT_PATH . "libs/lib-tasks.php";
