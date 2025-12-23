<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Service\JWT;
use DateTime;
use DateTimeZone;

class AuthController extends Controller
{

    private $getteController;
    public function __construct() {
        parent::__construct();
        parent::set_static_dir_view('Modules/Auth/View/');
        $this->getteController = new GetterController;
    }

    public function auth(object $req)
    {
        // Garante POST
        if ($req->method !== 'POST') {
            return parent::apiView(405, [
                'status'  => 'error',
                'message' => 'Método não permitido'
            ]);
        }

        // Funciona com JSON e POST
        $user = $req->input('username');
        $pass = $req->input('password');

        if (!$user || !$pass) {
            return parent::apiView(400, [
                'status'  => 'error',
                'message' => 'Campos vazios não são permitidos!'
            ]);
        }

        // Exemplo simples (depois troca por banco)

        $userData = $this->getteController->getForUsername($user); 

        if (!$userData) {
            return parent::apiView(401, [
                'status'  => 'fail',
                'message' => 'Usuário não identificado!'
            ]);
        }

        #=========================
        #  validar senha
        #=========================

        if(!password_verify($pass, $userData['hash_password'])) 
        {
            return parent::apiView(401, [
                'status'  => 'fail',
                'message' => 'Senha incorreta!'
            ]);
        }

        // Login OK
        $jwt = new JWT();
        $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        
        $token = $jwt->encode([
            'uuid' => $userData['uuid'],
            'name' => $userData['name'],
            'username' => $user,
            'key' => $userData['key'],
            'create_date' =>  $now->getTimestamp(),
            'expired_date' => $now->modify(EXPIRED_JWT)->getTimestamp()
        ]);

        return parent::apiView(201, [
            'status'    => 'success',
            'token'     => $token,
            'token_desc' => strlen($token),
            'redirect'  => '/produtos'
        ]);
    }
    
    public function logout(Object $req)
    {
       
    }
}