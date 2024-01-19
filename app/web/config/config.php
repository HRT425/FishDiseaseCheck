<?php

require_once __DIR__ . '/../logger/debug.php';

class config
{
    public static function getEnv(string $req): string
    {
        $arr = "";
        $envArr = explode("\n", file_get_contents(__DIR__ . "/.env"));
        $envVal = [];
        foreach ($envArr as $key => $val) {
            $arr = explode('=', trim($val));
            $envVal += [$arr[0] => $arr[1]];
        }

        return $envVal[$req];
    }
}
