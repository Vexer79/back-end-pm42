<?php
// Підключаємо файл валідації
require 'validate.php';

// Оголошуємо змінні для зберігання помилок та значень полів
$errors = [];
$login = $email = $password = $confirm_password = $article = '';
$terms_checked = false;

// Якщо форма була надіслана, обробляємо її дані
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Отримуємо дані форми
    $form_data = $_POST;

    // Викликаємо функцію валідації з validate.php
    $errors = validate_form($form_data);

    // Зберігаємо значення полів, щоб не очищувати їх після перезавантаження
    $login = sanitize($form_data['login']);
    $email = sanitize($form_data['email']);
    $article = sanitize($form_data['article']);
    $terms_checked = isset($form_data['terms']);

    // Якщо немає помилок, перенаправляємо на іншу сторінку
    if (empty($errors)) {
        header('Location: success.html');
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

<form action="validator/validate.php" method="POST">
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
