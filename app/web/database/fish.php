<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';

class Fish extends DbData
{
    // 魚の種類を取得する
    public function getALLSpecies()
    {
        $sql = "select fishId, fishName, ImagePath from fish";
        $stmt = $this->query($sql, []);
        $species = $stmt->fetchAll();
        return $species;
    }

    public function getSpecies($fishId)
    {
        $sql = "select fishId, fishName, ImagePath from fish where fishId = ?";
        $stmt = $this->query($sql, [$fishId]);
        $species = $stmt->fetchAll();
        return $species;
    }

    // 魚の情報を登録する
    public function insertFish($fishId, $fishSpecies, $ImagePath, $fishTemp, $fishPH, $fishSS)
    {
        $sql = "insert into fish(fishId, fishSpecies, ImagePath, fishTemp, fishPH, fishSS) values(?, ?, ?, ?, ?, ?)";
        $stmt = $this->exec($sql, [$fishId, $fishSpecies, $ImagePath, $fishTemp, $fishPH, $fishSS]);
        $result = $stmt->fetchALL();
        return $result;
    }
}
