<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Core\Redirect;
use app\Service\JWT;
use Exception;

class AuthController extends Controller
{

    public function __construct() {
        parent::__construct();
        parent::set_static_dir_view('Modules/Auth/View/');

    }

    public function index(Object $req)
    {   
        
        try {
           
            $this->login($req);
         
        } catch (\Exception $e) {
            
            $msg = parent::components('View/Components/message.php',
            [
                'status' => json_decode($e->getMessage())->status,
                'message' => json_decode($e->getMessage())->message
            ]);

        }

        parent::html_render()
        ->load('Login/index.php')
        ->set([
            'title' => 'Autenticação',
            'message' => $msg ?? "",
            'texto' => 'Efetuar login'
        ])
        ->display();
    }

    private function login(Object $req)
    {   

        if(!$req->exist_post()) return;

        $user = $req->post('user');
        $pass = $req->post('pass');

        if(!$user && !$pass) return throw new Exception(json_encode(['status' => 'error', 'message' => 'Campos vazios não são permitidos!']));

        if($user !== 'admin' || $pass !== 'asd123') return throw new Exception(json_encode(['status' => 'error', 'message' => 'Usuario ou senha incorretos!']));
       
        if($user == 'admin' && $pass == 'asd123') 
        {
            $jwt = new JWT;
            $_SESSION[COOKIE_NAME] = $jwt->encode(['user' => $user, 'name' => 'Luís']);
            Redirect::to('/produtos');
        }
        
        return true;
    }
    
    public function logout(Object $req)
    {
       
    }
}