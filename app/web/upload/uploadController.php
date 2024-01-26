<?php

require_once __DIR__ . '/../database/condition.php';

class uploadController
{
    private string $userID;
    private string $imageData;

    private string $uploadDir = '../image/uploadPicture/';
    private string $filename;

    private array $extension = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png'
    ];

    public function __construct($userID, $imageData)
    {
        $this->userID = $userID;
        $this->imageData = $imageData;
    }

    // 既存の写真をフォルダに保存
    public function selectImage()
    {
        try {
            // ファイルの拡張子を取得
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            // ファイル名をユニークにする（例: timestamp + ランダム文字列 + 拡張子）
            $this->filename = time() . '_' . uniqid() . '.' . $extension;

            // 画像を移動
            $destination = $this->uploadDir . $this->filename;
            debug::logging($destination);
            move_uploaded_file($this->imageData, $destination);
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }

    // アプリ内で撮影した写真をフォルダに保存
    public function takeImage()
    {
        try {
            $data = base64_decode($this->imageData);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_buffer($finfo, $data);

            $this->filename = time() . '_' . uniqid() . '.' . $this->extension[$mime_type];
            $destination = $this->uploadDir . $this->filename;

            file_put_contents($destination, $data);
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }

    // APIを呼び出し、データベースに保存
    public function callAPIandDBsave()
    {
        try {
            // 魚の異常検知機能を呼び出す
            $json = file_get_contents('http://python/' . $this->filename);
            $obj = json_decode($json);

            $db_result = (new condition)->insertCondition($obj['result'], isset($obj['value']) ? $obj['value'] : null, $this->filename, $this->userID);

            return $db_result;
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }
}
