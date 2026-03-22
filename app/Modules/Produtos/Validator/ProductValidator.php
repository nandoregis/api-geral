<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use app\Modules\Produtos\Rules\ProductRules;

class ProductValidator
{
    private $errors = [];

    public function validateReference(mixed $reference)
    {    

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('reference', fn() => Validation::noExist($reference), 'Não está com o parametro reference, faça a correção.'),
            fn() => $this->helpBaseValidate('reference', fn() => Validation::isEmpty($reference), 'Reference não pode ser vazia.'),
            fn() => $this->helpBaseValidate('reference', fn() => !Validation::isString($reference), 'Reference deve ter o tipo string'),
            fn() => $this->helpBaseValidate('reference', fn() => !Validation::regex($reference, ProductRules::REFERENCE), 'Referência fora do formato esperado.')
        );
        
    }

    public function validateUUID(mixed $uuid)
    {   

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('uuid', fn() => Validation::noExist($uuid), 'Não está com o parametro uuid, faça a correção.'),
            fn() => $this->helpBaseValidate('uuid', fn() => Validation::isEmpty($uuid), 'UUID não foi informado, é obrigatorio!'),
            fn() => $this->helpBaseValidate('uuid', fn() => !Validation::isString($uuid), 'UUID deve ter o tipo string')
        );

    }

    public function validateName(mixed $name)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => Validation::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => Validation::isEmpty($name), 'Name não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::isString($name), 'Name deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::regex($name, ProductRules::NAME), 'Name fora do formato esperado')
        );
    }

    public function validateNameSize(mixed $name)
    {
        
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => Validation::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => Validation::isEmpty($name), 'name não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::isString($name), 'name deve ter o tipo string'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::regex($name, ProductRules::NAME_SIZE), 'name fora do formato esperado')
        );

    }

    public function validateColorHex( mixed $color_hex)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('color_hex', fn() => Validation::noExist($color_hex), 'Não está com o parametro color_hex, faça a correção.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => Validation::isEmpty($color_hex), 'color_hex não pode ser vazio.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !Validation::isString($color_hex), 'clor_hex deve ter o tipo string'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !Validation::regex($color_hex, ProductRules::COLOR_HEX), 'color_hex fora do formato esperado, formato esperado #FFFFFF.')
        );

    }

    public function validatePrice( mixed $price)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('price', fn() => Validation::noExist($price), 'Não está com o parametro price, faça a correção.'),
            fn() => $this->helpBaseValidate('price', fn() => Validation::isEmpty($price), 'price não pode ser vazio.'),
            fn() => $this->helpBaseValidate('price', fn() => !Validation::isString($price), 'price deve ter o tipo string'),
            fn() => $this->helpBaseValidate('price', fn() => !Validation::regex($price, ProductRules::PRICE), 'price fora do formato esperado, formato esperado : 0,00')
        );

    }

    public function validateQuantity( mixed $quantity)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::noExist($quantity), 'Não está com o parametro quantity, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::isEmpty($quantity), 'quantity não pode ser vazio.'),
            fn() => $this->helpBaseValidate('quantity', fn() => !Validation::isString($quantity), 'quantity deve ter o tipo string'),
            fn() => $this->helpBaseValidate('quantity', fn() => !Validation::regex($quantity, ProductRules::INT), 'quantity fora do formato esperado, formato esperado inteiro')
        );
    }
    
    public function validateArrayVariations(mixed $variations)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::noExist($variations), 'Não está com o parametro variations, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::isEmpty($variations), 'Paramentro variations não pode ser vazio, e deve ser um array'),
            fn() => $this->helpBaseValidate('quantity', fn() => !Validation::isArray($variations), 'Paramentro variations deve ter o tipo array')
        );
    }

    /** ===========================================
     * 
     *  metodo de callback
     * 
     * ============================================
     */
    private function baseValidate(callable ...$args) : bool
    {
        foreach ($args as $arg) { if($arg()) return false; }
        return true;
    }

    // retornar verdadeiro se houver erro.
    private function helpBaseValidate(
        string $description,
        callable $fn,
        string $messageError
    ) {

        if($fn()) {
            $this->errors[$description] = $messageError;
            return true;
        }

        return false;
    }

    //===========================================================

    public function getErrors()
    {
        return $this->errors;
    
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

}