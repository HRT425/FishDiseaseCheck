<?php

function session()
{
    // もしセッションが開始されていないなら、スタートする
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // ログインしていることが前提のアプリであるから
    if (!isset($_SESSION['userId']) || !isset($_SESSION['userName'])) {
        header('Location: ./user/login.php');
        exit();
    }
}
