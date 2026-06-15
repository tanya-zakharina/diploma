<?php include 'includes/header.php'; ?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Литература</span></li>
        </ul>
    </div>
</div>

        <!-- FILTERS -->
<section style="background-size:cover; background-position: center center;">
    <div class="container">
        <div class="filter-buttons text-center">
            <a href="games_russian.php" class="filter-item">Русский язык</a>
            <a href="games_literature.php" class="filter-item active">Литература</a>
        </div>
    </div>
</section>

<!-- START GAMES -->
<section class="games_area section-padding">
    <div class="container">
        <div class="row games-container">
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Хронология</span></h1>
                        <span>Расставь события по порядку</span>
                    </div>
                    <div class="game-content">
                        <img src="assets/img/chronology_pic.jpg" alt="">
                    </div>
                    <div class="text-center">
                        <a href="chronology_game.php" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Цитаты</span></h1>
                        <span>Сопоставь цитату и героя</span>
                    </div>
                    <div class="game-content">
                        <img src="assets/img/phrases_pic.jpg" alt="">
                    </div>
                    <div class="text-center">
                        <a href="phrases_game.php" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Жанры</span></h1>
                        <span>Определи жанр произведения</span>
                    </div>
                    <div class="game-content">
                        <img src="assets/img/genres_pic.jpg" alt="">
                    </div>
                    <div class="text-center">
                        <a href="genres_game.php" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END GAMES -->

<?php include 'includes/footer.php'; ?>
