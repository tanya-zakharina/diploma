<?php
header('Content-Type: application/json');
require 'config.php';

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Проверяем, что это POST-запрос
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$username = trim($_POST['username'] ?? 'Anonymous');
$text = trim($_POST['text'] ?? '');
$rating = intval($_POST['rating'] ?? 5);
$user_id = $_SESSION['user_id'] ?? null;

// Приоритет имени из сессии
if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
}

// Базовая валидация
if (empty($text)) {
    echo json_encode(['success' => false, 'error' => 'Текст отзыва пуст']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, username, text, rating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $username, $text, $rating]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    if (DEBUG) {
        // Включаем отображение всех ошибок на экран
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ]);
    } else {
        // Выключаем отображение ошибок пользователям
        echo json_encode(['success' => false]);
    }
}
