<?php

namespace app\Test;

use app\Factory\Href as FactoryHref;

class HrefTest extends FactoryHref
{

    /**
     * ERROR : Já existe item com essa chave
     */
    public function test_error_method_new()
    {   
        try {
            parent::new('a')->href('dashboard', '/dashboard');
            parent::new('a');
        } catch (\Exception $e) {
            exit("<pre>".$e."</pre>");
        }
    }

}