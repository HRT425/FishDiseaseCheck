<?php

class UUID
{
    public function createUUid()
    {
        $id = preg_replace_callback(
            '/0|1/',
            fn ($m) => dechex(random_int(...[[0, 15], [8, 11]][$m[0]])),
            '00001000_0000_1000_1000_000000001000'
        );
        return $id;
    }
}
