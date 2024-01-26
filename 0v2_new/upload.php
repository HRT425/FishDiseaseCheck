<?php
$target_dir = "uploads/"; // 保存するディレクトリ
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// ファイルが実際に画像かどうかをチェック
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "ファイルは画像です - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "ファイルは画像ではありません。";
        $uploadOk = 0;
    }
}

// その他のチェック（ファイルサイズ、既存のファイルの確認など）

if ($uploadOk == 0) {
    echo "申し訳ありません、ファイルはアップロードされませんでした。";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {          
        $directory = 'uploads/'; // ディレクトリのパス
        // ディレクトリ内のファイルとサブディレクトリを取得
        $files = scandir($directory);
        // 現在のファイル名
        $oldFileName = '';
        // 新しいファイル名
        $newFileName = 'img.jpg';
        foreach ($files as $file) {
            // '.' と '..' を除外
            if ($file != "." && $file != "..") {
                $oldFileName=$file;
            }
        }
        // 現在のファイル名
        $oldFileName = $directory.$oldFileName;
        // 新しいファイル名
        $newFileName = $directory.'img.jpg';
        // ファイル名を変更
        if (rename($oldFileName, $newFileName)) {
            shell_exec('python delete.py 2>&1');
            $output=shell_exec('python yolo.py 2>&1');
            echo $output;
        } else {
            echo "検知できませんでした。";
        }
    } else {
        echo "申し訳ありません、ファイルのアップロード中にエラーが発生しました。";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ボタンリンクのテスト</title>
</head>
<body>
    <form action="camera.php" method="post">
        <button type="submit">もう一度</button>
    </form>
</body>
</html>