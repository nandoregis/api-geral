<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use ArrayObject;

class ProductValidator
{
    
    public function reference(string $reference)
    {

        if( Validation::isEmpty($reference ) ) {
            return true;
        }

        

    }

}