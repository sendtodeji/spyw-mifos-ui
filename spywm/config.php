<?php

if (session_id() == '') {
    session_start();
}
require('phpGrid/conf.php');

global $conn;

$server = PHPGRID_DB_HOSTNAME;
$username = PHPGRID_DB_USERNAME;
$password = PHPGRID_DB_PASSWORD;
$database = PHPGRID_DB_NAME;
$port = 3382;

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;port=$port;", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}