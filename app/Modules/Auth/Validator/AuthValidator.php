<?php

namespace app\Modules\Auth\Validator;

use app\Core\Validation;
use app\Service\JWT;
use DateTime;
use DateTimeZone;

class AuthValidator extends Validation
{
   
    
    public function validateEmail(mixed $email)
    {    

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('email', fn() => self::noExist($email), 'Não está com o parametro email, faça a correção.'),
            fn() => $this->helpBaseValidate('email', fn() => self::isEmpty($email), 'email não pode ser vazia.'),
            fn() => $this->helpBaseValidate('email', fn() => !self::isString($email), 'email deve ter o tipo string'),
            fn() => $this->helpBaseValidate('email', fn() => !self::isEmail($email), 'email inválido')
        );
        
    }

    public function validatePassword(mixed $password)
    {   

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('password', fn() => self::noExist($password), 'Não está com o parametro password, faça a correção.'),
            fn() => $this->helpBaseValidate('password', fn() => self::isEmpty($password), 'password não pode ser vazia.'),
            fn() => $this->helpBaseValidate('password', fn() => !self::isString($password), 'password deve ter o tipo string')
        );

    }

    public function validateToken(mixed $token)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('token', fn() => self::noExist($token), 'Não está com o parametro token, faça a correção.'),
            fn() => $this->helpBaseValidate('token', fn() => self::isEmpty($token), 'token não pode ser vazia.'),
            fn() => $this->helpBaseValidate('token', fn() => !self::isString($token), 'token deve ter o tipo string'),
            fn() => $this->helpBaseValidate('token', fn() => $this->token_expired($token), 'token expirado')
        );
    }

    private function token_expired(string $token) : bool
    {
        $token = (new JWT)->decode($token);
        $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        
        if($now > $token['expired_date']) return true;
    
        return false;
    }

}   

