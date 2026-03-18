<?php

namespace app\Modules\Produtos\Rules;

class ProductRules
{
    public const REFERENCE = '/^[A-Z0-9_-]{3,50}$/';
    public const NAME = '/^[A-Za-zÀ-ÿ0-9\s\-\/]{3,100}$/';

}