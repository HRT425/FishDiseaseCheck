<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../uuid/uuid.php';

class Aquarium extends DbData
{
    // 水槽情報を取得する
    public function getAquarium(string $userID)
    {
        $sql = <<<EOF
            select * 
            from users as u 
            left join aquariumEnv as ae on u.aquariumEnvId = ae.aquariumEnvId
            left join aquariumStandards as st on ae.standardId = st.standardId
            where u.userID = ?
        EOF;
        $stmt = $this->query($sql, [$userID]);
        $items = $stmt->fetchAll();
        return $items;
    }

    // 水槽情報を登録する
    public function insertAquarium(string $standardId, int $configTemp)
    {
        // uuidを作成
        $aquariumEnvId = (new UUID)->createUUid();
        $userID = $_SESSION['userID'];

        $sql = <<<EOF
        insert into aquariumEnv(aquariumEnvId, standardId, configTemp) values(?, ?, ?);
        EOF;
        $stmt = $this->exec($sql, [$aquariumEnvId, $standardId, $configTemp]);
        $result = $stmt->fetchAll();

        if (!$result) {
        }

        $sql = <<<EOF
        update users set aquariumEnvId = ? where userID = ?;
        EOF;
        $stmt = $this->exec($sql, [$aquariumEnvId, $userID]);
        $result = $stmt->fetchAll();

        return $result;
    }
}
