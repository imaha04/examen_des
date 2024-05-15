<?php
session_start();
require_once 'connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

// Подготовленный запрос для получения хэшированного пароля из базы данных
$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
$stmt->execute([$login]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Аутентификация успешна
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['message'] = 'Вы успешно вошли в систему!';
    header('Location: profile.php');
    exit(); // Прерываем выполнение скрипта после редиректа
} else {
    // Неправильный логин или пароль
    $_SESSION['message'] = 'Неправильный логин или пароль';
    header('Location: index.php');
    exit(); // Прерываем выполнение скрипта после редиректа
}
?>
