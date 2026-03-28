<?php

namespace app\Core;

class Validation
{
    private array $errors = [];

    public function __construct() {
        
    }

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

    public static function noExist( mixed $value ) : bool
    {
        return !isset($value);
    }

    public static function regex( ? string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    public static function isArray( mixed $value)
    {
        return is_array($value);
    }

    public static function isString( mixed $value)
    {
        return is_string($value);
    }

    public static function isNumber( mixed $value)
    {
        return is_numeric($value);
    }

    public static function isEmail( mixed $email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function arrayHasKey(array $arr, string $key)
    {
        return isset($arr[$key]) ? $arr[$key] : false;
    }

    public static function hasCode(int $code, int $isCodeReturn) {
        return $code ? $code : $isCodeReturn;
    }

  

    /** ===========================================
     * 
     *  metodo de callback
     * 
     * ============================================
     */
    protected function baseValidate(callable ...$args) : bool
    {
        foreach ($args as $arg) { if($arg()) return false; }
        return true;
    }

    // retornar verdadeiro se houver erro.
    protected function helpBaseValidate(
        string $description,
        callable $fn,
        string $messageError
    ) {

        if($fn()) {
            $this->errors[$description] = $messageError;
            return true;
        }

        return false;
    }

    //===========================================================

    public function getErrors()
    {
        return $this->errors;
    
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}