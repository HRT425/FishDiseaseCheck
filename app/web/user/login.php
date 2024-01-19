<?php
//require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../pre_sub.php';
require_once __DIR__ . '/../logger/debug.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= $login_css ?>">
</head>
<body>
    <div class="container4">
    <p class="text1">ウオッチング</p>
        <div class="container3">
            
            <form method="POST" action="./login_db.php">
                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<p class="error_class">' . $_SESSION['login_error'] . '</p>';
                    unset($_SESSION['login_error']);
                } else {
                    echo '<p>利用するにあたってログインしてください。</p>';
                }
                ?>
                <table>
                    
                    <p>メールアドレス</p>

                    <input type="text" name="userEmail" required>        
                    <p>パスワード</p>
                    <input type="password" name="password" required>
                    <?php
                        if (isset($_GET['linkToken'])) {
                            debug::logging('login-linkToken-get');
                            echo '<input type="hidden" name="linkToken" value="' . $_GET['linkToken'] . '">';
                        }
                    ?>
                    <br>
                    <br>
                    <div class="bot">
                        <a href="./signup.php"><span class="button_image">新規登録はこちらから</span></a>
                        <colspan="2"><input type="submit" value="ログイン"></colspan>
                    </div>
                </table>
            </form>
        </div>
    </div>
</body>
