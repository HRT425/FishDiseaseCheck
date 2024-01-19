<?php

require_once __DIR__ . '/../config/config.php';

class  DbData  // DbDataクラスの宣言	
{

    protected  $pdo;  // PDOオブジェクト用のプロパティ（メンバ変数）の宣言						

    // コンストラクタ
    public  function  __construct()
    {
        $dbname = config::getEnv('dbname');
        $host = config::getEnv('host');
        $username = config::getEnv('username');
        $pass = config::getEnv('password');

        // PDOオブジェクトを生成する
        // データベース接続変数
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $user = $username;
        $password = $pass;

        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (Exception  $e) {
            echo 'Error:' . $e->getMessage();
            die();
        }
    }

    // SELECT文実行用のメソッド
    protected function query($sql, $array_params)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($array_params);
        return  $stmt;  // PDOステートメントオブジェクトを返すのでfetch( )、fetchAll( )で結果セットを取得									
    }

    // INSERT、UPDATE、DELETE文実行用のメソッド	
    protected function exec($sql,  $array_params)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($array_params);  // 成功：true、失敗：false
        return  $stmt;
    }
}
