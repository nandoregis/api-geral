<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use app\Modules\Produtos\Rules\ProductRules;

class ProductValidator extends Validation
{
   
    public function __construct() {
        parent::__construct();
    }

    public function validateReference(mixed $reference)
    {    

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('reference', fn() => self::noExist($reference), 'Não está com o parametro reference, faça a correção.'),
            fn() => $this->helpBaseValidate('reference', fn() => self::isEmpty($reference), 'Reference não pode ser vazia.'),
            fn() => $this->helpBaseValidate('reference', fn() => !self::isString($reference), 'Reference deve ter o tipo string'),
            fn() => $this->helpBaseValidate('reference', fn() => !self::regex($reference, ProductRules::REFERENCE), 'Referência fora do formato esperado.')
        );
        
    }

    public function validateUUID(mixed $uuid)
    {   

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('uuid', fn() => self::noExist($uuid), 'Não está com o parametro uuid, faça a correção.'),
            fn() => $this->helpBaseValidate('uuid', fn() => self::isEmpty($uuid), 'UUID não foi informado, é obrigatorio!'),
            fn() => $this->helpBaseValidate('uuid', fn() => !self::isString($uuid), 'UUID deve ter o tipo string')
        );

    }

    public function validateName(mixed $name)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => self::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => self::isEmpty($name), 'Name não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !self::isString($name), 'Name deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !self::regex($name, ProductRules::NAME), 'Name fora do formato esperado')
        );
    }

    public function validateNameSize(mixed $name)
    {
        
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => self::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => self::isEmpty($name), 'name não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !self::isString($name), 'name deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !self::regex($name, ProductRules::NAME_SIZE), 'name fora do formato esperado')
        );

    }

    public function validateColorHex( mixed $color_hex)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('color_hex', fn() => self::noExist($color_hex), 'Não está com o parametro color_hex, faça a correção.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => self::isEmpty($color_hex), 'color_hex não pode ser vazio.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !self::isString($color_hex), 'clor_hex deve ter o tipo string'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !self::regex($color_hex, ProductRules::COLOR_HEX), 'color_hex fora do formato esperado, formato esperado #FFFFFF.')
        );

    }

    public function validatePrice( mixed $price)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('price', fn() => self::noExist($price), 'Não está com o parametro price, faça a correção.'),
            fn() => $this->helpBaseValidate('price', fn() => self::isEmpty($price), 'price não pode ser vazio.'),
            fn() => $this->helpBaseValidate('price', fn() => !self::isString($price), 'price deve ter o tipo string'),
            fn() => $this->helpBaseValidate('price', fn() => !self::regex($price, ProductRules::PRICE), 'price fora do formato esperado, formato esperado : 0,00')
        );

    }

    public function validateQuantity( mixed $quantity)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => self::noExist($quantity), 'Não está com o parametro quantity, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => self::isEmpty($quantity), 'quantity não pode ser vazio.'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::isNumber($quantity), 'quantity deve ter o tipo int'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::regex($quantity, ProductRules::INT), 'quantity fora do formato esperado, formato esperado inteiro')
        );
    }
    
    public function validateArrayVariations(mixed $variations)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => self::noExist($variations), 'Não está com o parametro variations, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => self::isEmpty($variations), 'Paramentro variations não pode ser vazio, e deve ser um array'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::isArray($variations), 'Paramentro variations deve ter o tipo array')
        );
    }

}