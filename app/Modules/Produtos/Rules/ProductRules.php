<?php

namespace app\Modules\Produtos\Rules;

class ProductRules
{
    public const REFERENCE = '/^[A-Z0-9_-]{3,50}$/';
    public const NAME = '/^[A-Za-zÀ-ÿ0-9\s\-\/]{3,100}$/';
    public const NAME_SIZE = '/^([A-Z]{1,2}[0-9]?|UND|[0-9]{1,3})$/';
    public const COLOR_HEX = '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
    
}