<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/carender_db.php';
require_once __DIR__ . '/../logger/debug.php';

// Producutクラスの宣言
class NewProduct extends dbdata
{
    // 選択された日付を取り出す
    public function getItems($created_at)
    {
        $sql = <<<EOF
        SELECT c.created_at, w.Temp, w.PH, w.SS, hs.fishImage
        FROM aqua.calendar c 
        JOIN aqua.water w ON c.waterId = w.waterId
        JOIN aqua.healthStatus hs ON c.healthStatusId = hs.healthStatusId
        WHERE DATE_FORMAT(c.created_at, '%Y-%m-%d') = ?
        EOF;
        $stmt = $this->query($sql, [$created_at]);
        $fishData = $stmt->fetchAll();
        debug::logging('選択された日付の値');
        debug::logging($fishData);
        return $fishData;
    }
}
