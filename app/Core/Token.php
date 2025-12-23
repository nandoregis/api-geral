<?php

namespace app\Core;

class Token
{

    public static function validate(String $tk)
    {
        if(!$tk || $tk !== $_SESSION[COOKIE_NAME]) return null;

        
        return true;
    }

    public static function get_token()
    {
        return isset($_SESSION[COOKIE_NAME]) ? $_SESSION[COOKIE_NAME] : '';
    }
}