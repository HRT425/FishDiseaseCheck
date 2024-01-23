<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <p class="daf">魚の健康状態</p>
    <div class="main_content">
        <div class="main_content_area">
            <button id="area">＋</button>
            <p class="main_content_area_text">Tap</p>
        </div>
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
    <script src="./js/home.js"></script>
</body>
<footer>
    <div class="footer_content">
        <hr>
        <a class="footer_content_text1" type="button" onclick="location.href='./carender/carender.php'">　記　録　</a>
        <a class="footer_content_text1">|</a>
        <!--ログアウト.phpまだない-->
        <a class="footer_content_text1" type="button" onclick="location.href='./carender/carender.php'">ログアウト</a>
    </div>
</footer>
</html>