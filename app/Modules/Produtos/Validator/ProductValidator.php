<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use app\Modules\Produtos\Rules\ProductRules;

class ProductValidator
{
    private $errors = [];

    public function validateReference(string | null $reference)
    {   

        if (Validation::noExist($reference)) {
            $this->errors['reference'] = 'Não está com o parametro reference, faça a correção.';
            return false;
        }

        if (Validation::isEmpty($reference)) {
            $this->errors['reference'] = 'Referência não pode ser vazia.';
            return false;
        }

        if (!Validation::regex($reference, ProductRules::REFERENCE)) {
            $this->errors['reference'] = 'Referência fora do formato esperado.';
            return false;
        }

        return true;
    }

    public function validateUUID(string | null $uuid)
    {   

        if (Validation::noExist($uuid)) {
            $this->errors['uuid'] = 'Não está com o parametro uuid, faça a correção.';
            return false;
        }

        if (Validation::isEmpty($uuid)) {
            $this->errors['uuid'] = 'UUID não foi informado, é obrigatorio!';
            return false;
        }
    }

    public function validateName(string | null $name)
    {

        if (Validation::noExist($name)) {
            $this->errors['name'] = 'Não está com o parametro name, faça a correção.';
            return false;
        }

        if (Validation::isEmpty($name)) {
            $this->errors['name'] = 'nome não pode ser vazio.';
            return false;
        }

        if (!Validation::regex($name, ProductRules::NAME)) {
            $this->errors['name'] = 'nome fora do formato esperado.';
            return false;
        }

        return true;
    }

    public function validateNameSize(string | null $name)
    {
        if (Validation::noExist($name)) {
            $this->errors['name'] = 'Não está com o parametro name, faça a correção.';
            return false;
        }

        if (Validation::isEmpty($name)) {
            $this->errors['name'] = 'nome não pode ser vazio.';
            return false;
        }

        if (!Validation::regex($name, ProductRules::NAME_SIZE)) {
            $this->errors['name'] = 'nome fora do formato esperado.';
            return false;
        }

        return true;
    }

    public function validateColorHex(string | null $color_hex)
    {
        if (Validation::noExist($color_hex)) {
            $this->errors['color_hex'] = 'Não está com o parametro color_hex, faça a correção.';
            return false;
        }

        if(Validation::isEmpty($color_hex)) {
            $this->errors['color_hex'] = 'color_hex não pode ser vazio.';
            return false;
        }

        if(!Validation::regex($color_hex, ProductRules::COLOR_HEX)) {
            $this->errors['color_hex'] = 'color_hex fora do formato esperado, formato correto #FFFFFF';
            return false;
        }

        
    }

    public function getErrors()
    {
        return $this->errors;
    
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

}