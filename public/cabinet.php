<?php
require 'config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT * FROM results WHERE user_id = ? ORDER BY played_at DESC LIMIT 10');
$stmt2->execute([$_SESSION['user_id']]);
$results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Мой профиль</span></li>
        </ul>
    </div>
</div>

<section class="account section-padding wow fadeInUp" style="background-image: url(assets/img/bg/section-2.jpg);  background-size:cover; background-position: center center;">
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
    <h2 class="counter-num"><?= count($results) ?></h2>
</div>
</div>
</div>

<div class="text-center">
<a href="logout.php" class="btn_two">Выйти из аккаунта</a>
</div>
</div><!--- END CONTAINER -->
</section>

<?php include 'includes/footer.php'; ?>
