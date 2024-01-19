<?php

require_once __DIR__ . '/../logger/debug.php';
require_once __DIR__ . '/../config/config.php';

class CurlHTTPClient
{
    // cURLメソッド
    public static function HTTPrequest(string $URL, array $header, ?array $data = null): array
    {
        $json_data = json_encode($data);

        // curlセッションの開始
        $ch = curl_init();

        // オプションの設定
        $options = [
            CURLOPT_URL            => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_POSTFIELDS     => $json_data
        ];

        curl_setopt_array($ch, $options);

        $json_data = curl_exec($ch);

        $error_no = curl_errno($ch); // エラー番号を取得

        if ($error_no) {
            $errors = curl_error($ch); // エラーメッセージを取得
            $info = curl_getinfo($ch); // 送信情報を取得

            debug::logging($error_no);
            debug::logging($errors);
            debug::logging($info);
        }

        //curlセッションを終了する
        curl_close($ch);

        // JSONデータを連想配列に変換
        $array_data = json_decode($json_data, true);

        return $array_data;
    }
}
