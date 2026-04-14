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
            fn() => $this->helpBaseValidate('reference', fn() => self::isEmpty($reference), 'Referência não pode ser vazia.'),
            fn() => $this->helpBaseValidate('reference', fn() => !self::isString($reference), 'Referência deve ter o tipo string'),
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
            fn() => $this->helpBaseValidate('name', fn() => self::isEmpty($name), 'Nome não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !self::isString($name), 'Nome deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !self::regex($name, ProductRules::NAME), 'O nome está fora do formato esperado.')
        );
    }

    public function validateNameSize(mixed $name)
    {
        
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => self::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => self::isEmpty($name), 'Nome não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !self::isString($name), 'Nome deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !self::regex($name, ProductRules::NAME_SIZE), 'Nome fora do formato esperado')
        );

    }

    public function validateColorHex( mixed $color_hex)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('color_hex', fn() => self::noExist($color_hex), 'Não está com o parametro color_hex, faça a correção.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => self::isEmpty($color_hex), 'A cor hex não pode ser vazio.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !self::isString($color_hex), 'A cor hex deve ter o tipo string'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !self::regex($color_hex, ProductRules::COLOR_HEX), 'A cor hex fora do formato esperado, formato esperado #FFFFFF.')
        );

    }

    public function validatePrice( mixed $price)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('price', fn() => self::noExist($price), 'Não está com o parametro price, faça a correção.'),
            fn() => $this->helpBaseValidate('price', fn() => self::isEmpty($price), 'O preço não pode ser vazio.'),
            fn() => $this->helpBaseValidate('price', fn() => !self::isString($price), 'O preço deve ter o tipo string'),
            fn() => $this->helpBaseValidate('price', fn() => !self::regex($price, ProductRules::PRICE), 'O preço está fora do formato esperado, o que se é esperado : 0,00')
        );

    }

    public function validateQuantity( mixed $quantity)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => self::noExist($quantity), 'Não está com o parametro quantity, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => self::isEmpty($quantity), 'Quantidade não pode ser vazio.'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::isNumber($quantity), 'Quantidade deve ter o tipo inteiro.'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::regex($quantity, ProductRules::INT), 'Quantidade está fora do formato esperado, numero inteiro se é esperado.')
        );
    }
    
    public function validateArrayVariations(mixed $variations)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => self::noExist($variations), 'Não está com o parametro variations, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => self::isEmpty($variations), 'Paramentro de variações não pode ser vazio, e deve ser um array'),
            fn() => $this->helpBaseValidate('quantity', fn() => !self::isArray($variations), 'Paramentro de variações deve ter o tipo array')
        );
    }

}