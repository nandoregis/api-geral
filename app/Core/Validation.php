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
}