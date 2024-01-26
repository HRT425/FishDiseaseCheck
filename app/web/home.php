<!DOCTYPE html>
<html lang="ja" dir="ltr" itemscope itemtype="http://schema.org/Article">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/home.css">
    <script defer src="./js/home.js"></script>
</head>

<body>
    <p class="daf">魚の健康状態</p>
    <div class="main_content">
        <label class="upload-label">

            <p class="daa" onclick="location.href='./home-camera.php'">写真を撮るならTap！</p>
        </label>
    </div>
    <div class="content">
        <label class="upload-label">
            <p class="daa">画像をアップロード</p>
            <input type="file" id="example" multiple>
        </label>
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