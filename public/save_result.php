<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "guest"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$score = intval($_POST['score'] ?? 0);
$game = $_POST['game'] ?? 'accent';

try {
    $stmt = $pdo->prepare("INSERT INTO results (user_id, game_name, score) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $game, $score]);

    $stmt = $pdo->prepare("UPDATE users SET points = points + ? WHERE id = ?");
    $stmt->execute([$score, $user_id]);

    echo json_encode(["status" => "ok"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}