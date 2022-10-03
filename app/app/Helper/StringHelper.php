<?php

namespace App\Helper;

class StringHelper
{
    public static function randString($length = 32): string
    {
        $s = '';
        if (empty($chars)) {
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        }
        while (strlen($s) < $length) {
            $s .= substr($chars, rand(0, strlen($chars) - 1), 1);
        }
        return $s;
    }
}
