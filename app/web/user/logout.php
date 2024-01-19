<?php
session_start();

// セッション情報を破棄
$_SESSION = [];

// クッキー情報を破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 1000, '/');
}

session_destroy();

// ログインページに遷移する
header('Location: ' . './login.php');
