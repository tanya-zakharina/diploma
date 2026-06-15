<?php

const DEBUG = false;

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    $host     = $env['DB_HOST'];
    $dbname   = $env['DB_NAME'];
    $username = $env['DB_USER'];
    $password = $env['DB_PASS'];
} else {
    $host     = 'localhost';
    $dbname   = 'diploma';
    $username = 'root';
    $password = '';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}
session_start();
?>
