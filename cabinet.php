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
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Образовательная веб-платформа">
		<meta name="keywords" content="agency, business, corporate, creative, html5, modern, multipurpose, One Page, parallax, startup">		
		<!-- SITE TITLE -->
		<title>Русский язык и литература</title>			
		<!-- Latest Bootstrap min CSS -->
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">		
		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
		<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
		<link rel="stylesheet" href="assets/fonts/themify-icons.css">
		<!--- owl carousel Css-->
		<link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">	
		<!--jquery-simple-mobilemenu Css-->
        <link rel="stylesheet" href="assets/css/jquery-simple-mobilemenu.css">			
		<!-- MAGNIFIC CSS -->
		<link rel="stylesheet" href="assets/css/magnific-popup.css">		
		<!-- animate CSS -->
		<link rel="stylesheet" href="assets/css/animate.css">	
		<!-- Style CSS -->					
		<link rel="stylesheet" href="assets/css/style.css">					
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body data-spy="scroll" data-offset="80">

		<!-- START NAVBAR -->  
		<?php include 'includes/nav.php'; ?>
		<!-- END NAVBAR -->		

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


		<!-- START FOOTER -->
		<?php include 'includes/footer.php'; ?>
		<!-- END FOOTER -->	
	
	<!-- Latest jQuery -->
		<script src="assets/js/jquery-1.12.4.min.js"></script>
	<!-- Latest compiled and minified Bootstrap -->
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- modernizer JS -->		
		<script src="assets/js/modernizr-2.8.3.min.js"></script>	
	<!-- jquery-simple-mobilemenu.min -->
		<script src="assets/js/jquery-simple-mobilemenu.js"></script>		
	<!-- owl-carousel min js  -->
		<script src="assets/owlcarousel/js/owl.carousel.min.js"></script>					
	<!-- magnific-popup js -->               
		<script src="assets/js/jquery.magnific-popup.min.js"></script>						
	<!-- countTo js -->
		<script src="assets/js/jquery.inview.min.js"></script>								
	<!-- scrolltopcontrol js -->
		<script src="assets/js/scrolltopcontrol.js"></script>			
	<!-- WOW - Reveal Animations When You Scroll -->
		<script src="assets/js/wow.min.js"></script>				
	<!-- scripts js -->
		<script src="assets/js/scripts.js"></script>
    </body>
</html>