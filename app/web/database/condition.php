<?php

require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../uuid/uuid.php';

class condition extends dbdata
{
    // AIからの結果を登録する
    public function insertCondition($result, $value, $imgPath, $userID)
    {
        try {
            $conditionID = (new UUID)->createUUid();
            $sql = "insert into `condition`(conditionID, result, value, imgPath, userID) values(?, ?, ?, ?, ?)";

            $stmt = $this->exec($sql, [$conditionID, $result, $value, $imgPath, $userID]);
            $result = $stmt->fetch();
            return $result;
        } catch (\Throwable $e) {
            debug::logging($e);
            return 1;
        }
    }
}
