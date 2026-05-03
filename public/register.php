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

<?php include 'includes/header.php'; ?>

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

<?php include 'includes/footer.php'; ?>
