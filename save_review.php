<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '1. Скрипт запущен<br>';

require 'config.php';
echo '2. config.php подключён<br>';

$username = trim($_POST['username'] ?? '');
$text = trim($_POST['text'] ?? '');
$rating = intval($_POST['rating'] ?? 5);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
}

if (empty($username) || empty($text)) {
    echo json_encode(['success' => false, 'error' => 'Заполните все поля']);
    exit;
}

if ($rating < 1 || $rating > 5) $rating = 5;

echo '3. Данные получены<br>';

$stmt = $pdo->prepare('INSERT INTO reviews (user_id, username, text, rating) VALUES (?, ?, ?, ?)');
$stmt->execute([$user_id, $username, $text, $rating]);

echo '4. Запрос выполнен<br>';

echo json_encode(['success' => true]);