<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class HealthStatus extends DbData
{
    // healthStatusテーブル内のデータを取り出す
    public function getCondition($healthStatusId)
    {
        $sql = "select fishImage, fishJudge from water where healthStatusId = ?";
        $stmt = $this->query($sql, [$healthStatusId]);
        $conditions = $stmt->fetch();
        return $conditions;
    }

    // waterテーブルに取得したデータを追加する
    public function insertCondition($healthStatusId, $fishImage, $fishJudge)
    {
        $sql = "insert into healthStatus(healthStatusId, fishImage, fishJudge) values(?, ?, ?)";
        $stmt = $this->exec($sql, [$healthStatusId, $fishImage, $fishJudge]);
        $condition = $stmt->fetch();
        return $condition;
    }
}
