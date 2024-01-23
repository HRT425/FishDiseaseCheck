<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Calendar extends DbData
{
    // 現在の水槽の状況を取り出す
    public function getAquariumInfo($userID)
    {
        $sql = <<<EOF
        SELECT 
          c.created_at as date,
          w.Temp as waterTemp,
          w.PH as waterPH,
          w.SS as waterTSS,
          h.fishImage,
          h.fishJudge
        FROM calendar c
        LEFT JOIN water w ON c.waterId = w.waterId
        LEFT JOIN healthStatus h ON c.healthStatusId = h.healthStatusId
        WHERE c.userID = ?
        ORDER BY c.created_at DESC
        LIMIT 5;
        EOF;;
        $stmt = $this->query($sql, [$userID]);
        $date = $stmt->fetchAll();
        return $date;
    }

    // calendarテーブルへのデータ登録処理
    public function insertCalendar($calendarId, $userID, $waterId, $healthStatusId)
    {
        $sql = "insert into calendar(calendarId, userID, waterId, healthStatusId) values(?, ?, ?, ?)";
        $stmt = $this->query($sql, [$calendarId, $userID, $waterId, $healthStatusId]);
        $result = $stmt->fetch();
        return $result;
    }
}
