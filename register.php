<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $error = 'Заполните все поля';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE name = ?');
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $error = 'Такой логин уже занят';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, password) VALUES (?, ?)');
            $stmt->execute([$login, $hash]);
            $success = 'Регистрация успешна! <a href="login.php">Войти</a>';
        }
    }
}
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

        <section class="formpage wow fadeInUp" style="background-size:cover; background-position: center center;">
            <div class="container" style="max-width: 500px;">
                <div class="text-center">
                    <h2 class="name-title">Регистрация</h2>
                </div>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="text-center">Логин</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-center">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn_one">Зарегистрироваться</button>
                    </div>
                    <p class="mt-3 text-center">Уже есть аккаунт? <a href="login.php">Войти</a></p>
                </form>
            </div>
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