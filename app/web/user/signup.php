<?php
require_once __DIR__ . '/../escape/escape.php';

if (isset($_SESSION['signup_error'])) {
    echo '<p class="error_class">' . $_SESSION['signup_error'] . '</p>';
    unset($_SESSION['signup_error']);
}

// 変数の初期化
$userName = '';
$userEmail = '';

?>
<p>Fish Health Check</p>
<img src="../image/icon_sample.png" alt="icon" width="150px" , height="150px">
<form method="POST" action="./signup_db.php">

    <p>ニックネーム</p>
    <p><input type="text" name="userName" value="<?= h($userName) ?>" placeholder="入力" required></p>

    <p>メールアドレス</p>
    <p><input type="text" name="userEmail" value="<?= h($userEmail) ?>" placeholder="入力" required></p>

    <p>パスワード</p>
    <p><input type="password" name="password" placeholder="入力" required></p>


    <p><input type="submit" value="登録"></p>
</form>

<a href="./login.php"><span class="button_image">ログインへ</span></a>