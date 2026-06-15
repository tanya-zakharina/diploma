<?php

const DEBUG = true;

$host = 'localhost';
$dbname = 'diploma';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}
session_start();
?>
