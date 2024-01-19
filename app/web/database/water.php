<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Water extends DbData
{
    // waterテーブル内のデータを取り出す
    public function getWater($waterId)
    {
        $sql = "select waterTemp, waterPH, waterTSS from water where waterId = ?";
        $stmt = $this->query($sql, [$waterId]);
        $waters = $stmt->fetch();
        return $waters;
    }

    // waterテーブルに取得したデータを追加する
    public function insertWater($waterId, $Temp, $PH, $SS, $waterJudge)
    {
        $sql = "insert into water(waterId, Temp, PH, SS, waterJudge) values(?, ?, ?, ?, ?)";
        $stmt = $this->exec($sql, [$waterId, $Temp, $PH, $SS, $waterJudge]);
        $waters = $stmt->fetch();
        return $waters;
    }
}
