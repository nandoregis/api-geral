<?php

namespace app\Modules\Auth\Controller;

use app\Core\HttpCode;
use app\Factory\Response;
use app\Modules\Auth\Validator\AuthValidator;
use app\Service\JWT;
use DateTime;
use DateTimeZone;

class SetterAuthController
{

    private $authValidator;
    private $getterAuthController;

    public function __construct()
    {
        $this->authValidator = new AuthValidator;
        $this->getterAuthController = new GetterAuthController;
    }


    public function auth(object $req)
    {
        $email = $req->input('email','');
        $password = $req->input('password','');
        $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        $this->authValidator->validateEmail($email);
        $this->authValidator->validatePassword($password);

        if($this->authValidator->hasErrors()) 
        {
            return Response::error(HttpCode::UNAUTHORIZED, $this->authValidator->getErrors());
        }

        $authDataUser = $this->getterAuthController->getByEmail($email); 

        if(!$authDataUser)
        {
            return Response::error(HttpCode::UNAUTHORIZED, "Usuário não identificado!");
        }

        if(!password_verify($password, $authDataUser['hash_password']))
        {
            return Response::error(HttpCode::UNAUTHORIZED, "Senha incorreta!");
        }

        $token = (new JWT)->encode(
            [
                'uuid' => $authDataUser['uuid'],
                'name' => $authDataUser['name'],
                'email' => $email,
                'create_date' => $now->getTimestamp(),
                'expired_date' => $now->modify(EXPIRED_JWT)->getTimestamp()
            ]
        );

        return Response::success(HttpCode::OK, "Login realizado com sucesso", [
            'token' => $token
        ]);
    }

    public function me(object $req)
    {
        $token = $req->input('token','');
        $expired = (new JWT)->isTokenExpired($token);

        if($expired) return Response::error(HttpCode::UNAUTHORIZED, "Token expirado!");

        $tokenData = (new JWT)->decode($token);

        return Response::success(HttpCode::OK, "Dados do usuário", $tokenData);
    }

}