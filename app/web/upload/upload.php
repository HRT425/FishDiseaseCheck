<?php

require_once __DIR__ . '/uploadController.php';
require_once __DIR__ . '/../logger/debug.php';
require_once __DIR__ . '/../user/session.php';

session();

debug::logging('開始');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    debug::logging('受け取リ');

    debug::logging($_SESSION);
    debug::logging($_SESSION['userID']);

    $userID = $_SESSION['userID'];

    debug::logging($_FILES);

    /* 
    if (既存の写真をアップロードした場合) 
    else (アプリ内で撮影した写真をアップロードした場合)

    */
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        debug::logging("既存の写真をアップロード");

        $imageData = $_FILES['image']['tmp_name'];

        $uploadController = new uploadController($userID, $imageData);
        $uploadController->selectImage();
    } else {
        debug::logging("アプリ内で撮影した写真をアップロード");

        $imageData = $_POST['image'];

        $uploadController = new uploadController($userID, $imageData);
        $uploadController->takeImage();
    }

    debug::logging('ok');

    $error = $uploadController->callAPIandDBsave();

    if ($error) {
        $_SESSION['uploadError'] = 'データベースの処理中にエラーが発生しました。';
    }

    header('Location: /web/home.php');
    exit();
} else {
    $_SESSION['uploadError'] = 'データの取得に失敗しました。';

    header('Location: http://locahost:8080/web/home.php');
    exit();
}
