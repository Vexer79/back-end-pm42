<?php
// Оголошуємо змінні для зберігання помилок та значень полів
$errors = [];
$login = $email = $password = $confirm_password = $article = '';
$terms_checked = false;

// Якщо форма була надіслана, обробляємо її дані
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валідація логіну
    if (empty($_POST['login'])) {
        $errors['login'] = 'Логін не може бути порожнім.';
    } elseif (strlen($_POST['login']) < 3) {
        $errors['login'] = 'Логін має містити щонайменше 3 символи.';
    } else {
        $login = htmlspecialchars($_POST['login']);
    }

    // Валідація електронної пошти
    if (empty($_POST['email'])) {
        $errors['email'] = 'Електронна пошта не може бути порожньою.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Невірний формат електронної пошти.';
    } else {
        $email = htmlspecialchars($_POST['email']);
    }

    // Валідація пароля
    if (empty($_POST['password'])) {
        $errors['password'] = 'Пароль не може бути порожнім.';
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = 'Пароль має бути не менше 6 символів.';
    } else {
        $password = $_POST['password'];
    }

    // Валідація підтвердження пароля
    if (empty($_POST['confirm_password'])) {
        $errors['confirm_password'] = 'Підтвердження пароля не може бути порожнім.';
    } elseif ($_POST['confirm_password'] !== $_POST['password']) {
        $errors['confirm_password'] = 'Паролі не збігаються.';
    }

    // Вибір статті
    if (empty($_POST['article'])) {
        $errors['article'] = 'Необхідно вибрати статтю.';
    } else {
        $article = htmlspecialchars($_POST['article']);
    }

    // Перевірка чекбокса
    if (!isset($_POST['terms'])) {
        $errors['terms'] = 'Необхідно погодитися з умовами.';
    } else {
        $terms_checked = true;
    }

    // Якщо немає помилок, можна обробляти дані або перенаправляти
    if (empty($errors)) {
        // Наприклад, перенаправлення на сторінку успіху
        header('Location: success.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Валідація форми на PHP</title>
    <style>
        .error { color: red; font-size: 0.9em; }
    </style>
</head>
<body>

<h1>Форма реєстрації</h1>

<form action="index.php" method="POST">
    <!-- Поле для логіну -->
    <label for="login">Логін:</label><br>
    <input type="text" id="login" name="login" value="<?= $login ?>"><br>
    <span class="error"><?= $errors['login'] ?? '' ?></span><br><br>

    <!-- Поле для електронної пошти -->
    <label for="email">Електронна пошта:</label><br>
    <input type="text" id="email" name="email" value="<?= $email ?>"><br>
    <span class="error"><?= $errors['email'] ?? '' ?></span><br><br>

    <!-- Поле для пароля -->
    <label for="password">Пароль:</label><br>
    <input type="password" id="password" name="password"><br>
    <span class="error"><?= $errors['password'] ?? '' ?></span><br><br>

    <!-- Поле для підтвердження пароля -->
    <label for="confirm_password">Підтвердження пароля:</label><br>
    <input type="password" id="confirm_password" name="confirm_password"><br>
    <span class="error"><?= $errors['confirm_password'] ?? '' ?></span><br><br>

    <!-- Вибір статті -->
    <label for="article">Виберіть статтю:</label><br>
    <select id="article" name="article">
        <option value="" <?= $article == '' ? 'selected' : '' ?>>-- Виберіть статтю --</option>
        <option value="article1" <?= $article == 'article1' ? 'selected' : '' ?>>Стаття 1</option>
        <option value="article2" <?= $article == 'article2' ? 'selected' : '' ?>>Стаття 2</option>
        <option value="article3" <?= $article == 'article3' ? 'selected' : '' ?>>Стаття 3</option>
    </select><br>
    <span class="error"><?= $errors['article'] ?? '' ?></span><br><br>

    <!-- Чекбокс для підтвердження погодження з умовами -->
    <label>
        <input type="checkbox" name="terms" <?= $terms_checked ? 'checked' : '' ?>>
        Погоджуюся з умовами
    </label><br>
    <span class="error"><?= $errors['terms'] ?? '' ?></span><br><br>

    <!-- Кнопка для відправлення форми -->
    <input type="submit" value="Надіслати">
</form>

</body>
</html>
