<?php include 'includes/header.php'; ?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Русский язык</span></li>
        </ul>
    </div>
</div>

        <!-- FILTERS -->
<section style="background-size:cover; background-position: center center;">
    <div class="container">
        <div class="filter-buttons text-center">
            <a href="games_russian.php" class="filter-item active">Русский язык</a>
            <a href="games_literature.php" class="filter-item">Литература</a>
        </div>
        <h4 class="text-center" style="color: red; margin-bottom: 40px;">В разработке...</h4>
    </div>
</section>

<!-- START GAMES -->
<section class="games_area section-padding">
    <div class="container">
        <div class="row games-container">
            <!-- RUSSIAN -->
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Ударения</span></h1>
                        <span>Выбери ударный гласный</span>
                    </div>
                    <div class="game-content">
                        <a href="#"><img src="assets/img/team/team1.jpg" alt=""></a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Падежи</span></h1>
                        <span>Определи падеж существительного</span>
                    </div>
                    <div class="game-content">
                        <a href="#"><img src="assets/img/team/team1.jpg" alt=""></a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12 game-item russian" data-wow-duration="1s" data-wow-delay="0.1s">
                <div class="game-cards">
                    <div class="game-info">
                        <h1><span class="game-title">Спряжения</span></h1>
                        <span>Определи спряжение глагола</span>
                    </div>
                    <div class="game-content">
                        <a href="#"><img src="assets/img/team/team1.jpg" alt=""></a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn_two">Играть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
