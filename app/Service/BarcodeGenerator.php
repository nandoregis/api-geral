<?php

namespace app\Service;

class BarcodeGenerator
{
    public static function generateEAN13WithPrefix(string $prefix = '789') : string
    {
        $code = $prefix;
        while(strlen($code) < 12) $code .= random_int(0,9);
        return $code . self::calculateCheckDigit($code);
    }

    private static function calculateCheckDigit(string $code) : int
    {
        $sum = 0;
        for($i = 0; $i < strlen($code); $i++) 
        {   
            $digit = (int)$code[$i];
            $sum += ( $i % 2 === 0) ? $digit  : $digit * 3;
        }

        return ( 10 - ($sum % 10) ) % 10;
        
    }
}