<?php
// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// 前月・次月リンクが選択された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    $ym = date('Y-m');
}

// タイムスタンプ（どの時刻を基準にするか）を作成し、フォーマットをチェック
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    // エラーが発生した場合は、現在の年月・タイムスタンプを取得
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット　例）2020-10-2
$today = date('Y-m-j');

// カレンダーのタイトルを作成　例）2020年10月
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か　0:日 1:月 2:火 ... 6:土
$youbi = date('w', $timestamp);

// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {
    $date = $ym . '-' . $day;
    $detailInfo = isset($day_details[$date]) ? $day_details[$date] : '';

    if ($today == $date) {
        $week .= '<td class="today"><a href="carender_detail.php?date=' . $date . '&selected_date=' . $ym . '">' . $day . '</a><br>' . $detailInfo;
    } else {
        $week .= '<td><a href="carender_detail.php?date=' . $date . '&selected_date=' . $ym . '">' . $day . '</a><br>' . $detailInfo;
    }
    $week .= '</td>';

    if ($youbi % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        $week = '';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>カレンダー</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <!-- リセットcss(destyle.css) -->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <style>
        .container {
            font-family: 'Noto Sans', sans-serif;
            margin-top: 80px;
        }

        h3 {
            margin-bottom: 30px;
        }

        th {
            height: 30px;
            text-align: center;
        }

        td {
            height: 100px;
        }

        .today {
            background: orange;
        }

        th:nth-of-type(1),
        td:nth-of-type(1) {
            color: red;
        }

        th:nth-of-type(7),
        td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3><a href="?ym=<?= $prev ?>">&lt;</a><?= $html_title ?><a href="?ym=<?= $next ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>Su</th>
                <th>Mo</th>
                <th>Tu</th>
                <th>We</th>
                <th>Th</th>
                <th>Fr</th>
                <th>Sa</th>
            </tr>
            <?php
            foreach ($weeks as $week) {
                echo $week;
            }
            ?>
        </table>
    </div>
</body>
<fotter>

</fotter>

</html>