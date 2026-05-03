<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE name = ?');
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: cabinet.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>

<?php include 'includes/header.php'; ?>

<section class="formpage wow fadeInUp" style="background-size:cover; background-position: center center;">
    <div class="container" style="max-width: 500px;">
        <div class="text-center">
            <h2 class="name-title">Вход</h2>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
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
                <button type="submit" class="btn_one">Войти</button>
            </div>
            <p class="mt-3 text-center">Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
