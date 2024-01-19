<?php
class dbdata
{
    protected $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=mysql;dbname=aqua;charset=utf8';
        $user = 'test';
        $password = 'test';
        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (Exception $e) {
            echo 'Error:' . $e->getMessage();
            die();
        }
    }

    // SELECT文実行用のメソッド
    protected function query($sql, $array_params)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($array_params);
        return $stmt;
    }

    // INSERT, UPDATE, DELETE文実行用のメソッド
    protected function exec($sql, $array_params)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($array_params);
        return $stmt;
    }
}

class Product extends dbdata
{
    // 選択された日付を取り出す
    public function getItems($carenderDate)
    {
        $sql = <<<EOF
        select hs.fishImage 
        from calendar c 
        left join healthStatus hs on c.healthStatusId = hs.healthStatusId 
        where to_char(c.created_at, 'yyyy-mm-dd') = ?
        EOF;
        $stmt = $this->query($sql, [$carenderDate]);
        $fishData = $stmt->fetchAll();
        return $fishData;
    }
}
