<?php

namespace app\Core;

class UUID
{
    public static function generator() {         
        $bytes = random_bytes(15);
        return bin2hex($bytes);
    }
}