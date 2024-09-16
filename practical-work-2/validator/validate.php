<?php
// Функція для очищення даних
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Функція для валідації даних форми
function validate_form($data) {
    $errors = [];

    // Очищення вхідних даних
    $login = sanitize($data['login'] ?? '');
    $email = sanitize($data['email'] ?? '');
    $password = sanitize($data['password'] ?? '');
    $confirm_password = sanitize($data['confirm_password'] ?? '');
    $article = sanitize($data['article'] ?? '');
    $terms = $data['terms'] ?? '';

    // Валідація логіну
    if (empty($login)) {
        $errors['login'] = 'Логін не може бути порожнім.';
    } elseif (strlen($login) < 3) {
        $errors['login'] = 'Логін має містити щонайменше 3 символи.';
    }

    // Валідація електронної пошти
    if (empty($email)) {
        $errors['email'] = 'Електронна пошта не може бути порожньою.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Невірний формат електронної пошти.';
    }

    // Валідація пароля
    if (empty($password)) {
        $errors['password'] = 'Пароль не може бути порожнім.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Пароль має бути не менше 6 символів.';
    }

    // Підтвердження пароля
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Підтвердження пароля не може бути порожнім.';
    } elseif ($confirm_password !== $password) {
        $errors['confirm_password'] = 'Паролі не збігаються.';
    }

    // Вибір статті
    if (empty($article)) {
        $errors['article'] = 'Необхідно вибрати статтю.';
    }

    // Перевірка погодження з умовами
    if (empty($terms)) {
        $errors['terms'] = 'Необхідно погодитися з умовами.';
    }

    // Повертаємо масив помилок
    return $errors;
}
