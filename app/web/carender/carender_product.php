<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/carender_db.php';

// Producutクラスの宣言
class NewProduct extends dbdata
{
    // 選択された日付を取り出す
    public function getItems($carenderDate)
    {
        $sql = "SELECT f.*, w.waterTemp, w.waterPH, w.waterTSS, c.carenderDate
                FROM aqua.fish AS f
                LEFT JOIN aqua.water AS w ON f.carenderDate = w.carenderDate
                LEFT JOIN aqua.carender AS c ON f.carenderDate = c.carenderDate
                WHERE c.carenderDate = ?";
        $stmt = $this->query($sql, [$carenderDate]);
        $fishData = $stmt->fetchAll();
        return $fishData;
    }
}
