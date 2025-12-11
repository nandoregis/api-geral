<?php

namespace app\Core;

use app\Factory\Href;

class Navigation
{
    private $href;
    public function __construct() 
    {
        $this->href = new Href;
        
    }


    public function user()
    {       
        
        $this->href
        ->new('dashboard')
        //---------------------------------
        ->new('produtos')
        ->href('produtos','/produtos/list')
        ->href('config','/produtos/config');
    
        return $this->href->get_all();
    }

    public function admin() 
    {
        $href =  new Href;
       
        $href
        ->new('admin');

        return $href->get_all();
    }



}