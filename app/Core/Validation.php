<?php

namespace app\Core;

class Validation
{

    public static function isEmpty( ...$values ) : array | bool
    {   

        $keyIsEmpty = [];

        foreach ($values as $key => $value) {
            if(is_null($value) || empty($value) || $value === "" || $value === [] ) {
                array_push($keyIsEmpty, $key);
            }
        }

        return empty($keyIsEmpty) ? false : $keyIsEmpty;
    
    }

    public static function regex(string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    public static function arrayHasKey(array $arr, string $key)
    {
        return isset($arr[$key]) ? $arr[$key] : false;
    }

    public static function hasCode(int $code, int $isCodeReturn) {
        return $code ? $code : $isCodeReturn;
    }
}