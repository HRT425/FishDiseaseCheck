<!DOCTYPE html>
<html>
<head>
  <title>トップページ</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/front-page.css">
  <style>
    body {
      /* ボディ要素に背景画像を設定 */
      background-image: url('./image/3545341_s.jpg');
      background-size: cover; /* 画像を表示領域いっぱいに広げる */
      background-position: center center; /* 画像を中央に配置 */
      background-repeat: no-repeat; /* 画像の繰り返しを禁止 */
    }
  </style>
</head>
<body>
  <div class="front-header">
    <nav>
      <div style="display:table; width:10%;">
        <div style="display:table-cell; vertical-align:middle;">
          <h2>にぎり寿司</h2>
        </div>
      </div>      
      <ul>
        <li><button class="overview-button" type="button" onclick="location.href='./app_overview.php'">アプリ概要</button></li>
        <li><button class="use-button" type="button" onclick="location.href='./app_use.php'">アプリの使い方</button></li>
      </ul>
    </nav>
  </div>
  <hr>

  <main class="main-contents">
    
    <section class="group01">

    <h1 style="text-align:center">ウオッチング</h1>
  <ul class="center-buttons">
    <li><button class="sign-button" type="button" onclick="location.href='./user/signup.php'">Sign Up</button></li>
    <li><button class="login-button" type="button" onclick="location.href='./user/login.php'">Login</button></li>
  </ul>
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