<?php

namespace app\Core;

class Token
{

    public static function validate(String $tk)
    {
        if(!$tk || $tk !== $_SESSION[COOKIE_NAME]) return null;

        
        return true;
    }

}