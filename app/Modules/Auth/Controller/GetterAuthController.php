<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Modules\Auth\Model\AuthModel;

class GetterAuthController extends Controller

{
    private $model;

    public function __construct() 
    {
        $this->model = new AuthModel;
    }

    public function getByEmail(string $username) : array
    {
        return $this->model->getByEmail($username);
    }

    public function getByUUID(String $uuid) : Array
    {
        return $this->model->getByUUID($uuid);
    }
    
}