<!DOCTYPE html>
<html>
<head>
  <title>トップページ</title>
  <meta charset="UTF-8">
  <!-- リセットcss(destyle.css) -->
  <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
  <link rel="stylesheet" href="./css/front-page.css">
  <!--<style>
    body {
      /* ボディ要素に背景画像を設定 */
      background-image: url('./image/3545341_s.jpg');
      background-size: cover; /* 画像を表示領域いっぱいに広げる */
      background-position: center center; /* 画像を中央に配置 */
      background-repeat: no-repeat; /* 画像の繰り返しを禁止 */
    }
  </style>-->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
  <header class="front-header">
    <div class="header-inner">
      <div class="logo">
        <img src="./image/図2.png">
      </div>
      <!--<h2 class="header-title">ウオッチング</h2>-->
      <nav class="header-nav">
        <div class="header-nav-item">
          <a href="./user/signup.php" class="header-button header-signup">新規登録</a>
        </div>
        <div class="header-nav-item">
          <a href="./user/login.php"class="header-button header-login">ログイン</a>
        </div>
        
        <!--<ul>
          <li class="button">
            <p><a href='./user/signup.php'>Sign Up</a></p>
          </li>
          <li class="button">
            <p><a href='./user/login.php'>Login</a></p>
          </li>
          <li class="button">
            <p><a href='./app_overview.php'>アプリ概要</a></p>
          </li>
          <li class="button">
            <p><a href='./app_use.php'>アプリの使い方</a></p>
          </li>
        </ul>-->
      </nav>
    </div>
  </header>
    <hr>

    <main class="main-contents">
      
      <section class="group01">

        <ul class="slideshow-fade resizeimage">
          <li><img src="./image/2.jpg" alt="スライドショー画像1" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/3.jpg" alt="スライドショー画像2" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/4.jpg" alt="スライドショー画像3" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/5.jpg" alt="スライドショー画像4" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/10.jpg" alt="スライドショー画像5" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/19.jpg" alt="スライドショー画像6" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
          <li><img src="./image/35.jpg" alt="スライドショー画像7" style="width: 80%; height: auto; display: block; margin: 0 auto;"></li>
        </ul>


        <script>
          $(function(){
            $(".slideshow-fade li").css({"position":"relative","overflow":"hidden"});
            $(".slideshow-fade li").hide().css({"position":"absolute","top":0,"left":0});
            $(".slideshow-fade li:first").addClass("fade").show();
            setInterval(function(){
              var $active = $(".slideshow-fade li.fade");
              var $next = $active.next("li").length?$active.next("li"):$(".slideshow-fade li:first");
              $active.fadeOut(1000).removeClass("fade");
              $next.fadeIn(1000).addClass("fade");
            },2000);
          });
        </script>
            <!--<h2>このアプリについて</h2>
            <div class="contents01">
              <img class="img1" src="./image/image01.jpg" alt="">
              <div class="detail">
                <h2>アプリ概要</h2>
                <p>hogehoge</p>
              </div>
            </div>

            <h2>アプリの使用</h2>
            <div class="contents01">
              <div class="detail">
                <h2>使い方は</h2>
                <p></p>
              </div>
              <img class="img2" src="./image/image03.jpg" alt="">
            </div>

            <h2>参考の使い方</h2>
            <div class="contents01">
              <img class="img1" src="./image/image01.jpg" alt="">
              <div class="detail">
                <h2>参考の使い方は</h2>
                <p>hogehoge</p>
              </div>
            </div>-->
      </section>
      <br>
    </main>
</body>
</html>