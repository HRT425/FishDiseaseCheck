<?php
require_once __DIR__ . '/user/session.php';

session();

$image_name = isset($_SESSION['image_name']) ? $_SESSION['image_name'] : null;
$result = isset($_SESSION['result']) ? $_SESSION['result'] : null;

if (isset($_SESSION['uploadError'])) {
    echo '<h3>' . $_SESSION['uploadError'] . '</h3>';
    unset($_SESSION['uploadError']);
    $image_path = '/inference_image/origin/' . $image_name;
} else {
    if ($image_name) {
        $image_path = '/inference_image/inference/disease/' . explode('.', $image_name)[0] . '/image0.jpg';
    }
}

?>

<!DOCTYPE html>
<html lang="ja" dir="ltr" itemscope itemtype="http://schema.org/Article">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/home.css">
    <script defer src="./js/home.js"></script>
</head>

<body>
    <p class="daf">魚の健康状態</p>
    <?php
    if ($result === 0) {
        echo "<h4>健康です。</h4>";
    } else if ($result === 1) {
        echo "<h4>病気の可能性があります。</h4>";
    }
    if ($image_name) {
        echo "<img src=$image_path alt='魚の画像'>";
    }
    ?>
    <div class="main_content">
        <label class="upload-label">
            <p class="daa" onclick="location.href='./home-camera.php'">写真を撮るならTap！</p>
        </label>
    </div>
    <div class="content">
        <form action="./upload/upload.php" method="post" enctype="multipart/form-data">
            <!-- <label class="upload-label">
                <p class="daa">画像をアップロード</p>
                <input type="file" id="button" multiple>
            </label> -->
            <input type="file" name="image">
            <input type="submit" value="アップロード">
        </form>
        <!-- プレビュー画像を追加する -->
        <div id="preview"></div>
    </div>
    <br>
    <footer>
        <div class="footer_content">
            <hr>
            <a class="footer_content_text1" type="button" onclick="location.href='./carender/carender.php'">　記　録　</a>
            <a class="footer_content_text1">|</a>
            <!--ログアウト.phpまだない-->
            <a class="footer_content_text1" type="button" onclick="location.href='./carender/carender.php'">ログアウト</a>
        </div>
    </footer>
</body>

</html>