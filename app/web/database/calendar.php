<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Calendar extends DbData
{
    // 現在の水槽の状況を取り出す
    public function getAquariumInfo($userId)
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
        WHERE c.userId = ?
        ORDER BY c.created_at DESC
        LIMIT 5;
        EOF;;
        $stmt = $this->query($sql, [$userId]);
        $date = $stmt->fetchAll();
        return $date;
    }

    // calendarテーブルへのデータ登録処理
    public function insertCalendar($calendarId, $userId, $waterId, $healthStatusId)
    {
        $sql = "insert into calendar(calendarId, userId, waterId, healthStatusId) values(?, ?, ?, ?)";
        $stmt = $this->query($sql, [$calendarId, $userId, $waterId, $healthStatusId]);
        $result = $stmt->fetch();
        return $result;
    }
}
