<!DOCTYPE html>
<html lang="ja" dir="ltr" itemscope itemtype="http://schema.org/Article">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/home.css">
    <script defer src="./js/camera.js"></script>
</head>

<body>
    <p class="daf">魚の健康状態</p>
    <div class="main_content">
        <div class="main_content_camera">
            <video id="video">Video stream not available.</video>
        </div><br>

        <form name="upload_form" action="./upload/upload.php" method="post">
            <input id="inputImage" type="hidden" name="image" value="jj">
            <button id="main_content_startbutton">撮影！！！！！</button>
            <canvas id="canvas">
                <textarea id="readStr"></textarea>
            </canvas>
            <button type="submit">送信</button>

        </form>

    </div>
</body>

</html>