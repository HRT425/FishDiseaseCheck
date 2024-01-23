<?php

session_start();

require_once __DIR__ . '/../database/user.php';

// 送られてきたデータを受け取る
$userName = $_POST['userName'];
$userEmail = $_POST['userEmail'];
$password = $_POST['password'];

// バリデーションはメールアドレスのみとする
// メールアドレスのバリデーションはfilter_var()を使い、RFCに準拠しないメルアドはエラーとする
if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup_error'] = '正しいメールアドレスを入力してください。'; // エラーメッセージをセットし
    header('Location: ./signup.php');
    exit();
}

// Userオブジェクトを生成し、ユーザー登録処理を行うsignUp( )メソッドを呼び出し、その結果のメッセージを受け取る
// データベースに登録する
$userID = (new User)->signUp($userName, $userEmail, $password);

// ユーザー情報をセッションに保持する
$_SESSION['userID'] = $userID;
$_SESSION['userName'] = $userName;

header('Location: ../breedingEnv/fish-select.php');
exit;
