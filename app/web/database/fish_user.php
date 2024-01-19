<?php

require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../uuid/uuid.php';

class FishUser extends dbdata
{
    // fishIdとfishNumberを取得する
    public function getfishID(string $userId)
    {
        $sql = <<<EOF
        select fu.fishId, fu.fishNumber, fish.fishSpecies, fish.ImagePath
        from fish_user as fu inner join fish on fu.fishId = fish.fishId 
        where fu.userId = ?
        EOF;
        $stmt = $this->query($sql, [$userId]);
        $fish = $stmt->fetch();
        debug::logging($fish);
        return $fish;
    }

    // IoTへの返答を取得する
    public function getfishInfo($userId)
    {
        $sql = <<<EOF
        select fish.fishName, fish.area, aq.configTemp
        from fish_user as fu 
        left join fish on fu.fishId = fish.fishId
        left join users on fu.userId = users.userId
        left join aquariumEnv aq on aq.aquariumEnvId = users.aquariumEnvId
        where fu.userId = ?
        EOF;
        $stmt = $this->query($sql, [$userId]);
        $tps = $stmt->fetch();
        return $tps;
    }

    // userIdとfishIdを登録する
    public function insertID(string $userId, int $fishId, int $fishNumber)
    {
        $fish_userId = (new UUID)->createUUid();

        $sql = 'insert into fish_user(fish_userId, userId, fishId, fishNumber) values(?, ?, ?, ?)';
        $stmt = $this->exec($sql, [$fish_userId, $userId, $fishId, $fishNumber]);
        $result = $stmt->fetch();
        return $result;
    }
}
