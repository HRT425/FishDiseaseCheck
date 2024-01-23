<?php

require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../uuid/uuid.php';

class FishUser extends dbdata
{
    // fishIdとfishNumberを取得する
    public function getfishID(string $userID)
    {
        $sql = <<<EOF
        select fu.fishId, fu.fishNumber, fish.fishSpecies, fish.ImagePath
        from fish_user as fu inner join fish on fu.fishId = fish.fishId 
        where fu.userID = ?
        EOF;
        $stmt = $this->query($sql, [$userID]);
        $fish = $stmt->fetch();
        debug::logging($fish);
        return $fish;
    }

    // IoTへの返答を取得する
    public function getfishInfo($userID)
    {
        $sql = <<<EOF
        select fish.fishName, fish.area, aq.configTemp
        from fish_user as fu 
        left join fish on fu.fishId = fish.fishId
        left join users on fu.userID = users.userID
        left join aquariumEnv aq on aq.aquariumEnvId = users.aquariumEnvId
        where fu.userID = ?
        EOF;
        $stmt = $this->query($sql, [$userID]);
        $tps = $stmt->fetch();
        return $tps;
    }

    // userIDとfishIdを登録する
    public function insertID(string $userID, int $fishId, int $fishNumber)
    {
        $fish_userID = (new UUID)->createUUid();

        $sql = 'insert into fish_user(fish_userID, userID, fishId, fishNumber) values(?, ?, ?, ?)';
        $stmt = $this->exec($sql, [$fish_userID, $userID, $fishId, $fishNumber]);
        $result = $stmt->fetch();
        return $result;
    }
}
