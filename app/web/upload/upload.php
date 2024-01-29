<?php

require_once __DIR__ . '/uploadController.php';
require_once __DIR__ . '/../logger/debug.php';
require_once __DIR__ . '/../user/session.php';

session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userID = $_SESSION['userID'];

    /* 
    if (既存の写真をアップロードした場合) 
    else (アプリ内で撮影した写真をアップロードした場合)

    */
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $imageData = $_FILES['image']['tmp_name'];

        $uploadController = new uploadController($userID, $imageData);
        $image_name = $uploadController->selectImage();
    } else {

        $imageData = $_POST['image'];

        $uploadController = new uploadController($userID, $imageData);
        $image_name = $uploadController->takeImage();
    }

    $error_text = $uploadController->callAPIandDBsave();

    if ($error_text) {
        $_SESSION['uploadError'] = $error_text;
    }

    $_SESSION['image_name'] = $image_name;

    header('Location: /web/home.php');
    exit();
} else {
    $_SESSION['uploadError'] = 'データの取得に失敗しました。';

    header('Location: http://locahost:8080/web/home.php');
    exit();
}
