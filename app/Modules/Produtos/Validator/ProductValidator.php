<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use app\Modules\Produtos\Rules\ProductRules;

class ProductValidator
{
    private $errors = [];

    public function validateReference(string | null $reference)
    {    

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('reference', fn() => Validation::noExist($reference), 'Não está com o parametro reference, faça a correção.'),
            fn() => $this->helpBaseValidate('reference', fn() => Validation::isEmpty($reference), 'Referência não pode ser vazia.'),
            fn() => $this->helpBaseValidate('reference', fn() => !Validation::regex($reference, ProductRules::REFERENCE), 'Referência fora do formato esperado.')
        );
        
    }

    public function validateUUID(string | null $uuid)
    {   

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('uuid', fn() => Validation::noExist($uuid), 'Não está com o parametro uuid, faça a correção.'),
            fn() => $this->helpBaseValidate('uuid', fn() => Validation::isEmpty($uuid), 'UUID não foi informado, é obrigatorio!'),
        );

    }

    public function validateName(string | null $name)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => Validation::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => Validation::isEmpty($name), 'nome não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::regex($name, ProductRules::NAME), 'nome fora do formato esperado')
        );
    }

    public function validateNameSize(string | null $name)
    {
        
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('name', fn() => Validation::noExist($name), 'Não está com o parametro name, faça a correção.'),
            fn() => $this->helpBaseValidate('name', fn() => Validation::isEmpty($name), 'nome não pode ser vazio.'),
            fn() => $this->helpBaseValidate('name', fn() => !Validation::regex($name, ProductRules::NAME_SIZE), 'nome fora do formato esperado')
        );

    }

    public function validateColorHex(string | null $color_hex)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('color_hex', fn() => Validation::noExist($color_hex), 'Não está com o parametro color_hex, faça a correção.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => Validation::isEmpty($color_hex), 'color_hex não pode ser vazio.'),
            fn() => $this->helpBaseValidate('color_hex', fn() => !Validation::regex($color_hex, ProductRules::COLOR_HEX), 'color_hex fora do formato esperado, formato esperado #FFFFFF.')
        );

    }

    public function validatePrice(string | null $price)
    {

        return $this->baseValidate(
            fn() => $this->helpBaseValidate('price', fn() => Validation::noExist($price), 'Não está com o parametro price, faça a correção.'),
            fn() => $this->helpBaseValidate('price', fn() => Validation::isEmpty($price), 'price não pode ser vazio.'),
            fn() => $this->helpBaseValidate('price', fn() => !Validation::regex($price, ProductRules::PRICE), 'price fora do formato esperado, formato esperado : 0,00')
        );

    }

    public function validateQuantity(string | null $quantity)
    {
        return $this->baseValidate(
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::noExist($quantity), 'Não está com o parametro quantity, faça a correção.'),
            fn() => $this->helpBaseValidate('quantity', fn() => Validation::isEmpty($quantity), 'quantity não pode ser vazio.'),
            fn() => $this->helpBaseValidate('price', fn() => !Validation::regex($quantity, ProductRules::INT), 'quantity fora do formato esperado, formato esperado inteiro')
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