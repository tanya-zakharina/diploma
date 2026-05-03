<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- START NAVBAR -->  
<div id="navigation" class="navbar-light bg-faded site-navigation">
    <div class="container-fluid">
        <div class="row">
            <div class="col-20 align-self-center">
                <div class="site-logo">
                    <a href="index.php"><img src="assets/img/logo.svg" alt=""></a>          				
                </div>
            </div>

            <div class="col-60 d-flex">
                <nav id="main-menu">
                    <ul>
                        <li class="menu-item-has-children"><a href="games_russian.php">Игры</a>
                            <ul>										
                                <li><a href="games_russian.php">Русский язык</a></li>
                                <li><a href="games_literature.php">Литература</a></li>			
                            </ul>
                        </li>			  				  
                        <li class="menu-item-has-children"><a href="mission.php">О проекте</a>
                            <ul>
                                <li><a href="mission.php">Миссия</a></li>									
                                <li><a href="about_teacher.php">О преподавателе</a></li>
                                <li><a href="howitworks.php">Как это работает</a></li>
                                <li><a href="reviews.php">Отзывы</a></li>	
                            </ul>
                        </li>													  
                        <li><a href="#footer">Контакты</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-20 d-none d-xl-block text-end align-self-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cabinet.php" class="btn_one"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user_name']) ?></a>
                <?php else: ?>
                    <a href="login.php" class="btn_one">Войти</a>
                <?php endif; ?>
            </div>

            <ul class="mobile_menu">
                <div class="site-logo">
                    <a href="index.php"><img src="assets/img/logo.svg" alt=""></a>          				
                </div>						
                <li><a href="#">Игры</a>
                    <ul class="sub-menu">										
                        <li><a href="games_russian.php">Русский язык</a></li>
                        <li><a href="games_literature.php">Литература</a></li>						
                    </ul>
                </li>						
                <li><a href="#">О проекте</a>
                    <ul class="sub-menu">
                        <li><a href="mission.php">Миссия</a></li>										
                        <li><a href="about_teacher.php">О преподавателе</a></li>
                        <li><a href="howitworks.php">Как это работает</a></li>	
                        <li><a href="reviews.php">Отзывы</a></li>									
                    </ul>
                </li>						
                <li><a href="#footer">Контакты</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="cabinet.php">👤 <?= htmlspecialchars($_SESSION['user_name']) ?></a></li>
                    <li><a href="logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="login.php">Войти</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>			
        </div>
    </div>
</div> 	  
<!-- END NAVBAR -->