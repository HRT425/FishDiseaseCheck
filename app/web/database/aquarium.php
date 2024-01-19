<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../uuid/uuid.php';

class Aquarium extends DbData
{
    // 水槽情報を取得する
    public function getAquarium(string $userId)
    {
        $sql = <<<EOF
            select * 
            from users as u 
            left join aquariumEnv as ae on u.aquariumEnvId = ae.aquariumEnvId
            left join aquariumStandards as st on ae.standardId = st.standardId
            where u.userId = ?
        EOF;
        $stmt = $this->query($sql, [$userId]);
        $items = $stmt->fetchAll();
        return $items;
    }

    // 水槽情報を登録する
    public function insertAquarium(string $standardId, int $configTemp)
    {
        // uuidを作成
        $aquariumEnvId = (new UUID)->createUUid();
        $userId = $_SESSION['userId'];

        $sql = <<<EOF
        insert into aquariumEnv(aquariumEnvId, standardId, configTemp) values(?, ?, ?);
        EOF;
        $stmt = $this->exec($sql, [$aquariumEnvId, $standardId, $configTemp]);
        $result = $stmt->fetchAll();

        if (!$result) {
        }

        $sql = <<<EOF
        update users set aquariumEnvId = ? where userId = ?;
        EOF;
        $stmt = $this->exec($sql, [$aquariumEnvId, $userId]);
        $result = $stmt->fetchAll();

        return $result;
    }
}
