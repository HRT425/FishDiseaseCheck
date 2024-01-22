<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/calendar_db.php';

// Producutクラスの宣言
class NewProduct extends dbdata
{
    // 選択された日付を取り出す
    public function getItems($created_at)
    {
        $sql = "SELECT c.created_at, hs.imgPath
                FROM aqua.users u
                LEFT JOIN aqua.condition c ON u.userID = c.userID
                WHERE c.created_at = ?";
        $stmt = $this->query($sql, [$created_at]);
        $fishData = $stmt->fetchAll();
        return $fishData;
    }
}
