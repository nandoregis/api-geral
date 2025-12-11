<?php

namespace app\Modules\Produtos\Controller;

use app\Controller\Controller;
use app\View\ApiView;

class ProdutosController extends Controller
{

    #

    public function __construct() 
    {
        parent::__construct();
        
    }

    #
    public function index()
    {   

        parent::apiView(200, ['nome' => 'Luis'] );

    }

    public function getForUuid()
    {

    }


}