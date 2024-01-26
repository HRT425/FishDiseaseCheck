<?php

session_start();

require_once __DIR__ . '/../database/user.php';
require_once __DIR__ . '/../logger/debug.php';

//送られてきたユーザーIDとパスワードを受け取る
$userEmail = $_POST['userEmail'];
$password = $_POST['password'];

$user = new User;
list($userID, $userName) = $user->authUser($userEmail, $password);

debug::logging($userID);
debug::logging($userName);


if (empty($userID)) { //$userID
    $_SESSION['login_error'] = 'メールアドレス、パスワードを確認してください。';
    header('Location: ./login.php');
    exit();
}

$_SESSION['userID'] = $userID;
$_SESSION['userName'] = $userName;

debug::logging($_SESSION);

if (isset($_POST['linkToken'])) {
    header('Location: ../LINE/line_bot.php?userID=' . $userID . '&linkToken=' . $_POST['linkToken']);
    exit();
}

header('Location: ../upload/test.php');
exit();
