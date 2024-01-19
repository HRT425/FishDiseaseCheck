<?php
require_once __DIR__ . '/carender_db.php';
require_once __DIR__ . '/carender_product.php';

if (isset($_GET['date']) && isset($_GET['selected_date'])) {
    $selectedDate = $_GET['date'];
    $selectedYearMonth = $_GET['selected_date'];

    $product = new NewProduct();

    // getItems メソッドに $selectedDate を渡す
    $carender = $product->getItems($selectedDate);

    if ($carender && isset($carender[0])) {
        $fishImage = $carender[0]['fishImage'];
        $waterPH = isset($carender[0]['waterPH']) ? $carender[0]['waterPH'] : 60;
        $waterTemp = isset($carender[0]['waterTemp']) ? $carender[0]['waterTemp'] : 30;
        $waterTSS = isset($carender[0]['waterTSS']) ? $carender[0]['waterTSS'] : 70;
    } else {
        $fishImage = 'default_image.jpg';
        $waterPH = 60;
        $waterTemp = 30;
        $waterTSS = 70;
    }
} else {
    exit('無効なパラメータ');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細画面</title>
    <link rel="stylesheet" href="../css/aqua.css">
    <link rel="stylesheet" href="../css/notification.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <main class="main-contents">
        <section class="group01">
            <div class="contents01">
                <h3>魚の健康状態</h3>
                <div class="detail">
                    <img src="../image/<?php echo $fishImage; ?>" alt="魚の画像">
                </div>
            </div>
        </section>
        <section class="group02">
            <div class="contents02">
                <h3>水質状態</h3>
                <div class="detail">
                    <!-- グラフを表示するキャンバス -->
                    <canvas id="myChart" width="400" height="200"></canvas>
                    <div class="radio">
                        <input type="radio" name="amount" value="ph" id="pH"><label for="pH">pH値</label>
                        <input type="radio" name="amount" value="temp" id="water"><label for="water">水温</label>
                        <input type="radio" name="amount" value="tss" id="turbidity"><label for="turbidity">濁度</label>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // ラジオボタンの変更イベント
                            var radioButtons = document.querySelectorAll('input[name="amount"]');
                            radioButtons.forEach(function(radioButton) {
                                radioButton.addEventListener('change', function() {
                                    updateChart(this.value);
                                });
                            });

                            // 初期表示
                            updateChart(radioButtons[0].value);
                        });

                        // グラフ更新関数
                        function updateChart(amount) {
                            var labels = chartData.map(function(entry) {
                                return entry.date;
                            });

                            var data = chartData.map(function(entry) {
                                return entry[amount];
                            });

                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: amount,
                                        data: data,
                                        borderColor: 'rgb(75, 192, 192)',
                                        borderWidth: 2,
                                        fill: false
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: [{
                                            type: 'linear',
                                            position: 'bottom'
                                        }]
                                    }
                                }
                            });
                        }
                    </script>

</body>

</html>
<div class="slider"><!--スライダー -->
    <div class="slider-container">
        <span>pH値<span id="slider1Value"><?php echo $waterPH; ?></span></span><br>
        <input type="range" min="0" max="100" value="<?php echo $waterPH; ?>" class="slider" id="slider1">
    </div>
    <div class="slider-container">
        <span>水温<span id="slider2Value"><?php echo $waterTemp; ?></span></span><br>
        <input type="range" min="0" max="100" value="<?php echo $waterTemp; ?>" class="slider" id="slider2">
    </div>
    <div class="slider-container">
        <span>濁度<span id="slider3Value"><?php echo $waterTSS; ?></span></span><br>
        <input type="range" min="0" max="100" value="<?php echo $waterTSS; ?>" class="slider" id="slider3">
    </div>
</div>
</div>
</div>
</section>
<section class="group03">
    <div class="contents03">
        <h3>解決方法</h3>
        <div class="detail">
            <p>AIgroupと分の出力の仕方について相談</p>
        </div>
    </div>
</section>
<canvas id="myChart" width="400" height="200"></canvas>
</main>
<script>
    // データを各スライダーに反映させる
    const slider1 = document.getElementById('slider1');
    const slider2 = document.getElementById('slider2');
    const slider3 = document.getElementById('slider3');

    slider1.value = <?php echo $waterPH; ?>;
    slider2.value = <?php echo $waterTemp; ?>;
    slider3.value = <?php echo $waterTSS; ?>;

    // 3つのスライダー値を表示するためのエレメントを取得
    const slider1Value = document.getElementById('slider1Value');
    const slider2Value = document.getElementById('slider2Value');
    const slider3Value = document.getElementById('slider3Value');

    // スライダーの値を表示する関数
    function updateSliderValue() {
        slider1Value.textContent = slider1.value;
        slider2Value.textContent = slider2.value;
        slider3Value.textContent = slider3.value;
    }

    // スライダーの値が変更されたときの処理
    slider1.addEventListener('input', updateSliderValue);
    slider2.addEventListener('input', updateSliderValue);
    slider3.addEventListener('input', updateSliderValue);

    // 最初に一度スライダーの値を表示するために関数を呼び出す
    updateSliderValue();
    //slider1.disabled = true; // スライダーを変更不可にする
    //slider2.disabled = true; // スライダーを変更不可にする
    //slider3.disabled = true; // スライダーを変更不可にする
</script>
</body>
<footer>
    <!-- footer btn -->
    <section>
        <!--ボタンの作成リンクの付与-->
        <button class="button"></button>
        <div class="box">
            <section>
                <a href="../home.php" class="btn_24">ホーム</a>
                <a href="../carender/carender.php" class="btn_24">記録</a>
                <a href="../remind.php" class="btn_24">リマインド</a>
                <a href="../profile.php" class="btn_24">プロフィール</a>
            </section>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- footerスクリプト-->
    <script>
        $(function() {
            var button = $('.button');
            var box = $('.box');
            var timer;
            /*スクロール時の処理*/
            $(window).scroll(function() {
                button.addClass('is-active');
                clearTimeout(timer);

                timer = setTimeout(function() {
                    if ($(this).scrollTop()) {
                        button.removeClass('is-active');
                        box.removeClass('show');
                    } else {
                        button.removeClass('is-active');
                        box.removeClass('show');
                    }
                    /*１秒後に発火*/
                }, 100);
            });
            /*ボタンクリック時の処理*/
            button.on('click', function() {
                box.toggleClass('show');
            });
        });
    </script>

</footer>

</html>

</html>