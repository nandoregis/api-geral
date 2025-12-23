<?php

namespace app\Modules\Auth\Controller;

use app\Controller\Controller;
use app\Modules\Auth\Model\AuthModel;

class GetterController extends Controller

{
    private $model;
    public function __construct() 
    {
        $this->model = new AuthModel;
    }

    public function getForUsername(string $username) : array
    {
        return $this->model->getForUsername($username);
    }

    public function getUserForUUID(String $uuid) : Array
    {

        return $this->model->getUserForUUID($uuid);

    }
}