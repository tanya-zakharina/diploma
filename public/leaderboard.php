<?php
require 'config.php';

$game = $_GET['game'] ?? 'stress';
$allowed = ['stress', 'padezhi', 'genre'];

if (!in_array($game, $allowed)) {
    $game = 'stress';
}

// Названия игр для отображения
$gameNames = [
    'stress' => 'Ударения',
    'padezhi' => 'Падежи',
    'genre' => 'Жанры'
];

// Топ-10 по игре
$stmt = $pdo->prepare("
    SELECT u.name, MAX(r.score) as best_score 
    FROM results r
    JOIN users u ON r.user_id = u.id
    WHERE r.game_name = ?
    GROUP BY u.id
    ORDER BY best_score DESC
    LIMIT 10
");
$stmt->execute([$game]);
$leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Лучший результат текущего пользователя (если авторизован)
$myBest = null;
if (isset($_SESSION['user_id'])) {
    $stmt2 = $pdo->prepare("
        SELECT MAX(score) as my_best 
        FROM results 
        WHERE user_id = ? AND game_name = ?
    ");
    $stmt2->execute([$_SESSION['user_id'], $game]);
    $myBest = $stmt2->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include 'includes/header.php'; ?>

<style>
.leaderboard-container {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    border-radius: 30px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.leaderboard-title {
    text-align: center;
    font-size: 96px;
    font-family: "Vasek Italic_0", sans-serif;
    color: #1A489E;
    margin-bottom: 10px;
}

.leaderboard-sub {
    text-align: center;
    font-size: 18px;
    color: #666;
    margin-bottom: 30px;
}

.game-filter {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.filter-btn {
    background: white;
    border: 2px solid #1A489E;
    padding: 8px 20px;
    border-radius: 50px;
    color: #1A489E;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.filter-btn.active,
.filter-btn:hover {
    background: #1A489E;
    color: white;
}

.leaderboard-table {
    width: 100%;
    border-collapse: collapse;
}

.leaderboard-table th,
.leaderboard-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.leaderboard-table th {
    background: #f5f5f5;
    font-weight: 600;
    color: #1A489E;
}

.my-result {
    margin-top: 30px;
    padding: 15px;
    background: #D4FFD0;
    border-radius: 20px;
    text-align: center;
    font-weight: 600;
}

.btn-back {
    display: inline-block;
    margin-top: 20px;
    text-align: center;
    width: 100%;
}

@media only screen and (max-width: 480px) {
    .leaderboard-container {
        padding: 20px;
    }
    .leaderboard-title {
        font-size: 32px;
    }
    .filter-btn {
        padding: 5px 15px;
        font-size: 14px;
    }
}
</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Таблица лидеров</span></li>
        </ul>
    </div>
</div>

<section class="games_area section-padding">
    <div class="container">
        <div class="leaderboard-container">
            <div class="leaderboard-title">Таблица лидеров</div>
            <div class="leaderboard-sub">Лучшие результаты по играм</div>

            <div class="game-filter">
                <a href="leaderboard.php?game=stress" class="filter-btn <?= $game === 'stress' ? 'active' : '' ?>">Ударения</a>
                <a href="leaderboard.php?game=padezhi" class="filter-btn <?= $game === 'padezhi' ? 'active' : '' ?>">Падежи</a>
                <a href="leaderboard.php?game=genre" class="filter-btn <?= $game === 'genre' ? 'active' : '' ?>">Жанры</a>
            </div>

            <table class="leaderboard-table">
                <thead>
                    <th>Место</th>
                    <th>Игрок</th>
                    <th>Лучший результат</th>
                <table>
                </thead>
                <tbody>
                    <?php if (empty($leaders)): ?>
                        <tr><td colspan="3">Пока нет результатов. Будьте первым!</td></tr>
                    <?php else: ?>
                        <?php foreach ($leaders as $index => $row): ?>
                            <tr class="rank-<?= $index + 1 ?>">
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= $row['best_score'] ?> очков</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (isset($_SESSION['user_id']) && $myBest && $myBest['my_best'] !== null): ?>
                <div class="my-result">
                    Твой лучший результат в «<?= $gameNames[$game] ?>»: <strong><?= $myBest['my_best'] ?></strong> очков
                </div>
            <?php endif; ?>

            <div class="btn-back">
                <a href="games_russian.php" class="btn_two">← Вернуться к играм</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>