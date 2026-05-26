<?php

namespace app\Modules\Clientes\Controller;

use app\Controller\Controller;
use app\Core\HttpCode;
use app\Core\Validation;

class ClientesController extends Controller
{

    private $getterClientesController;
    public function __construct() 
    {
        parent::__construct();
        $this->getterClientesController = new GetterClientesController();
    }

    public function getAll(object $req) 
    {   
        $response = $this->getterClientesController->getAll();
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );  
    }

    public function getByUuid(object $req)
    {
        $response = $this->getterClientesController->getByUuid($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );  
    }

    public function create()
    {

    }

    public function update()
    {

    }   

    public function delete()
    {
        
    }

}