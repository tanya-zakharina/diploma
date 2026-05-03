<?php
$host = 'localhost';
$dbname = 'zaxaritk_diploma';
$username = 'zaxaritk_diploma';
$password = '4MOE%*uH&v1*';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}
session_start();
?>