<?php

class debug
{
    private static $dir = __DIR__ . '/../logger/debug.log';

    public static function logging($message)
    {
        file_put_contents(self::$dir, print_r($message, true), FILE_APPEND);
        file_put_contents(self::$dir, "\n", FILE_APPEND);
    }
}
