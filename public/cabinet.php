<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT * FROM results WHERE user_id = ? ORDER BY played_at DESC');
$stmt2->execute([$_SESSION['user_id']]);
$results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$totalGames = count($results);

// Таблица лидеров
$game = $_GET['game'] ?? 'stress';
$allowed = ['stress', 'cases', 'genre', 'chronology', 'quotes', 'conjugation'];

if (!in_array($game, $allowed)) {
    $game = 'stress';
}

$gameNames = [
    'stress' => 'Ударения',
    'cases' => 'Падежи',
    'genre' => 'Жанры',
    'chronology' => 'Хронология',
    'quotes' => 'Цитаты',
    'conjugation' => 'Спряжения'
];

// Топ-10 по игре
$stmt3 = $pdo->prepare("
    SELECT u.name, MAX(r.score) as best_score 
    FROM results r
    JOIN users u ON r.user_id = u.id
    WHERE r.game_name = ?
    GROUP BY u.id
    ORDER BY best_score DESC
    LIMIT 10
");
$stmt3->execute([$game]);
$leaders = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Лучший результат текущего пользователя
$myBest = null;
$stmt4 = $pdo->prepare("
    SELECT MAX(score) as my_best 
    FROM results 
    WHERE user_id = ? AND game_name = ?
");
$stmt4->execute([$_SESSION['user_id'], $game]);
$myBest = $stmt4->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<style>
.leaderboard-container {
    max-width: 600px;
    margin: 30px auto 0 auto;
    padding: 30px;
    margin-bottom: 80px;
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
}

.leaderboard-table th {
    background: #D4FFD0;
    font-weight: 600;
    color: #1A489E;
}

.my-result {
    margin-top: 20px;
    padding: 12px;
    text-align: center;
    margin-bottom:20px;
}

@media only screen and (max-width: 480px) {
    .leaderboard-container {
        padding: 20px;
        margin-top: 20px;
    }
    .leaderboard-title {
        font-size: 28px;
    }
    .filter-btn {
        padding: 5px 15px;
        font-size: 14px;
    }
    .leaderboard-table th,
    .leaderboard-table td {
        padding: 8px;
        font-size: 14px;
    }
}

</style>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Мой профиль</span></li>
        </ul>
    </div>
</div>

<section class="account section-padding wow fadeInUp" style="background-image: url(assets/img/bg/section-2.jpg); background-size:cover; background-position: center center;">
    <div class="container">
        <div class="section-title text-center">
            <h2><span class="title-teacher">Привет, <?= htmlspecialchars($user['name']) ?>!</span></h2>
        </div>

        <div class="row mb-4 counter_feature">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Баллы</h5>
                    <h2 class="counter-num"><?= $user['points'] ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Уровень</h5>
                    <h2 class="counter-num"><?= floor($user['points'] / 100) + 1 ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Игр пройдено</h5>
                    <h2 class="counter-num"><?= $totalGames ?></h2>
                </div>
            </div>
        </div>

        <!-- Таблица лидеров -->
        <div class="leaderboard-container">
            <div class="leaderboard-title">Таблица лидеров</div>
            <div class="leaderboard-sub">Лучшие результаты по играм</div>

            <div class="game-filter">
                <a href="cabinet.php?game=stress" class="filter-btn <?= $game === 'stress' ? 'active' : '' ?>">Ударения</a>
                <a href="cabinet.php?game=cases" class="filter-btn <?= $game === 'cases' ? 'active' : '' ?>">Падежи</a>
                <a href="cabinet.php?game=conjugation" class="filter-btn <?= $game === 'conjugation' ? 'active' : '' ?>">Спряжения</a>
                <a href="cabinet.php?game=chronology" class="filter-btn <?= $game === 'chronology' ? 'active' : '' ?>">Хронология</a>
                <a href="cabinet.php?game=quotes" class="filter-btn <?= $game === 'quotes' ? 'active' : '' ?>">Цитаты</a>
                <a href="cabinet.php?game=genre" class="filter-btn <?= $game === 'genre' ? 'active' : '' ?>">Жанры</a>
            </div>

                        <?php if ($myBest && $myBest['my_best'] !== null): ?>
                <div class="my-result">
                    Твой лучший результат в «<?= $gameNames[$game] ?>»:  <strong><?= $myBest['my_best'] ?></strong> очков
                </div>
            <?php endif; ?>

            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Игрок</th>
                        <th>Лучший результат</th>
                    </tr>
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

        </div>
                <div class="text-center">
            <a href="logout.php" class="btn_two">Выйти из аккаунта</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>