<?php

session_start();

require_once __DIR__ . '/../database/user.php';
require_once __DIR__ . '/../logger/debug.php';

//送られてきたユーザーIDとパスワードを受け取る
$userEmail = $_POST['userEmail'];
$password = $_POST['password'];

$user = new User;
list($userId, $userName) = $user->authUser($userEmail, $password);


if (empty($userId)) {//$userId
    $_SESSION['login_error'] = 'メールアドレス、パスワードを確認してください。';
    header('Location: ./login.php');
    exit();
}

$_SESSION['userId'] = $userId;
$_SESSION['userName'] = $userName;

if (isset($_POST['linkToken'])) {
    header('Location: ../LINE/line_bot.php?userId=' . $userId . '&linkToken=' . $_POST['linkToken']);
    exit();
}

header('Location: ../home.php');
