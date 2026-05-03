<?php
require 'config.php';

$limit = 12;
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT $limit");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
?>

<?php include 'includes/header.php'; ?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Отзывы</span></li>
        </ul>
    </div>
</div>

<section style="background-size:cover; background-position: center center;">
    <div class="container">
        <div class="filter-buttons text-center">
            <a href="mission.php" class="filter-item">Миссия</a>
            <a href="howitworks.php" class="filter-item">Как это работает</a>
            <a href="about_teacher.php" class="filter-item">О преподавателе</a>
            <a href="reviews.php" class="filter-item active">Отзывы</a>
        </div>
    </div>
</section>

<section class="reviews section-padding home-reviews load-more-block text-truncate-block" style="background-image: url(assets/img/bg/shape-1.png); background-size:cover; background-position: center center;">
    <div class="container stickers">
        <div class="row" id="reviews-container">
            <?php if (empty($reviews)): ?>
                <p class="text-center text-muted">Пока нет отзывов. Будьте первым!</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-offset="0">
                    <div class="single_sticker">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa fa-star<?= $i <= $review['rating'] ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                        <p><?= htmlspecialchars($review['text']) ?></p>
                        <small style="opacity:0.6;">— <?= htmlspecialchars($review['username']) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center" style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-top: 30px;">
            <?php if ($total > 12 && !isset($_GET['all'])): ?>
                <a href="reviews.php?all=1" class="btn_two">Показать больше</a>
            <?php endif; ?>
            <a href="javascript:void(0);" class="btn_one" id="open-review-modal">Оставить отзыв</a>
        </div>
    </div>
</section>

<script src="assets/js/reviews.js"></script>

<?php include 'includes/footer.php'; ?>
