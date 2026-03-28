<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Core\HttpCode;
use app\Core\Validation;

class AuthController extends Controller
{

    private $getterAuthController;
    private $setterAuthController;

    public function __construct() 
    {
        parent::__construct();
        $this->getterAuthController = new GetterAuthController;
        $this->setterAuthController = new SetterAuthController;
    }

    public function auth(object $req)
    {
        $response = $this->setterAuthController->auth($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }
    
}