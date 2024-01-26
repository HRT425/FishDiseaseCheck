<?php
function deleteFilesInDirectory($directoryPath) {
    // ディレクトリが存在するか確認
    if (!is_dir($directoryPath)) {
        echo "ディレクトリが存在しません: " . $directoryPath;
        return;
    }
    // ディレクトリを開く
    $handle = opendir($directoryPath);
    if ($handle !== false) {
        // ディレクトリ内の各ファイルに対して処理
        while (false !== ($entry = readdir($handle))) {
            // '.' と '..' をスキップ
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $filePath = $directoryPath . DIRECTORY_SEPARATOR . $entry;
            // ファイルなら削除
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }
        closedir($handle);
    }
}
// 使用例
$directoryPath = 'uploads/';
deleteFilesInDirectory($directoryPath);
?>

<!DOCTYPE html>
<html>
<head>
    <title>画像アップロード</title>
</head>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    画像を選択してください:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="アップロード" name="submit">
</form>

</body>
</html>
