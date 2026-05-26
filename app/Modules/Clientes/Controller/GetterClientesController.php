<?php

namespace app\Modules\Clientes\Controller;

use app\Modules\Clientes\Model\GetterClientesModel;

class GetterClientesController
{

    private $getterClientesModel;
    public function __construct() {
      $this->getterClientesModel = new GetterClientesModel();
    }

    public function getAll()
    {
        return $this->getterClientesModel->getAll();
    }

    public function getByUuid(object $req)
    {
        return $this->getterClientesModel->getByUuid($req->uri('uuid'));
    }

    public function getByEmail(object $req)
    {
        return $this->getterClientesModel->getByEmail($req->uri('email'));
    }


}