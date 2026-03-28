<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Core\HttpCode;
use app\Factory\Response;
use app\Modules\Auth\Model\AuthModel;
use app\Modules\Auth\Validator\AuthValidator;

class GetterAuthController extends Controller

{
    private $model;
    private $authValidator;

    public function __construct() 
    {
        $this->model = new AuthModel;
        $this->authValidator = new AuthValidator;
    }

    public function getByEmail(string $username) : array
    {
        return $this->model->getByEmail($username);
    }

    public function getByUUID(string $uuid) : array
    {
        return $this->model->getByUUID($uuid);
    }
    
}