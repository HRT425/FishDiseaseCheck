<?php

require_once __DIR__ . '/../database/condition.php';
require_once __DIR__ . '/../logger/debug.php';

class uploadController
{
    private string $userID;
    private string $imageData;

    private string $uploadDir = '../../inference_image/origin/';
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

        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
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

            move_uploaded_file($this->imageData, $destination);

            return $this->filename;
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }

    // アプリ内で撮影した写真をフォルダに保存
    public function takeImage()
    {
        try {

            $da = explode(',', $this->imageData);

            $data = base64_decode($da[1]);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $mime_type = finfo_buffer($finfo, $data);

            $this->filename = time() . '_' . uniqid() . '.' . $this->extension[$mime_type];
            $destination = $this->uploadDir . $this->filename;

            file_put_contents($destination, $data);

            return $this->filename;
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }

    // APIを呼び出し、データベースに保存
    public function callAPIandDBsave()
    {
        try {
            // 魚の異常検知機能を呼び出す
            $json = file_get_contents('http://ai-api/inference/' . $this->filename);
            debug::logging($json);
            $obj = json_decode($json);
            debug::logging($obj);

            if ($obj->fish_photographed_flag) {
                return '魚を認識に失敗しました。もう一度撮影してください。';
            }

            debug::logging($obj->result);

            $result = $obj->result ? 1 : 0;

            $db_result = (new condition)->insertCondition($result, $obj->credibility, $this->filename, $this->userID);

            return [$db_result ? 'データベースの処理中にエラーが発生しました。' : false, $result];
        } catch (\Throwable $e) {
            debug::logging($e);
        }
    }
}
