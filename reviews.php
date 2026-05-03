<?php
session_start();
require 'config.php';

$limit = isset($_GET['all']) ? 999 : 12;
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT $limit");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Образовательная веб-платформа">
    <title>Русский язык и литература</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="assets/css/jquery-simple-mobilemenu.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body data-spy="scroll" data-offset="80">

    <?php include 'includes/nav.php'; ?>

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

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr-2.8.3.min.js"></script>
    <script src="assets/js/jquery-simple-mobilemenu.js"></script>
    <script src="assets/owlcarousel/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.inview.min.js"></script>
    <script src="assets/js/scrolltopcontrol.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let reviewBtn = document.getElementById('open-review-modal');
        if (!reviewBtn) return;

        reviewBtn.addEventListener('click', function(e) {
            e.preventDefault();

            let modal = document.createElement('div');
            modal.className = 'review-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="modal-close">&times;</span>
                    <h3>Оставить отзыв</h3>
                    <div class="rating-input">
                        <i class="fa fa-star star" data-value="5"></i>
                        <i class="fa fa-star star" data-value="4"></i>
                        <i class="fa fa-star star" data-value="3"></i>
                        <i class="fa fa-star star" data-value="2"></i>
                        <i class="fa fa-star star" data-value="1"></i>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <input type="text" id="review-name" placeholder="Ваше имя" maxlength="50">
                    <?php endif; ?>
                    <textarea id="review-text" placeholder="Ваш отзыв" maxlength="500"></textarea>
                    <button class="btn_one" id="submit-review">Отправить отзыв</button>
                </div>
            `;
            document.body.appendChild(modal);
            modal.classList.add('active');

            modal.querySelector('.modal-close').addEventListener('click', () => {
                modal.classList.remove('active');
                setTimeout(() => modal.remove(), 300);
            });
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    setTimeout(() => modal.remove(), 300);
                }
            });

            let stars = modal.querySelectorAll('.star');
            let selectedRating = 0;

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.value);
                    stars.forEach(s => {
                        if (parseInt(s.dataset.value) <= selectedRating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });

            modal.querySelector('#submit-review').addEventListener('click', function() {
                let nameInput = modal.querySelector('#review-name');
                let name = nameInput ? nameInput.value.trim() : '';
                let text = modal.querySelector('#review-text').value.trim();

                if (selectedRating === 0) { alert('Пожалуйста, оцените нас звёздами'); return; }
                if (nameInput && name === '') { alert('Пожалуйста, введите ваше имя'); return; }
                if (text === '') { alert('Пожалуйста, напишите отзыв'); return; }

                let formData = new FormData();
                formData.append('username', name);
                formData.append('rating', selectedRating);
                formData.append('text', text);

                // Проверка перед отправкой
                console.log('Отправка данных:', { name, rating: selectedRating, text: text.substring(0, 50) });

                fetch('save_review_debug.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert('Спасибо за отзыв!');
                        modal.classList.remove('active');
                        setTimeout(() => modal.remove(), 300);
                        location.reload();
                    } else {
                        alert(data.error || 'Ошибка отправки');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Ошибка отправки: ' + error.message + '. Проверьте консоль (F12)');
                });
            });
        });
    });
    </script>
</body>
</html>