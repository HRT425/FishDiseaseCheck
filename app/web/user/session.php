<?php

function session()
{
    // もしセッションが開始されていないなら、スタートする
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // ログインしていないならlogin画面に移動
    if (!isset($_SESSION['userID']) || !isset($_SESSION['userName'])) {
        header('Location: http://localhost:8080/web/user/login.php');
        exit();
    }
}
