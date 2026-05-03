<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require 'config.php';

$username = trim($_POST['username'] ?? 'test');
$text = trim($_POST['text'] ?? 'test text');
$rating = intval($_POST['rating'] ?? 5);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
}

// Простая вставка без проверок
try {
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, username, text, rating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $username, $text, $rating]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>