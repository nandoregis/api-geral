<?php

namespace app\Modules\Produtos\Validator;

use app\Core\Validation;
use app\Modules\Produtos\Rules\ProductRules;

class ProductValidator
{
    private $errors = [];

    public function validateReference(string | null $reference)
    {

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
        if (Validation::isEmpty($uuid)) {
            $this->errors['uuid'] = 'UUID não foi informado, é obrigatorio!';
            return false;
        }
    }

    public function validateName(string | null $name)
    {

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

    public function getErrors()
    {
        return $this->errors;
    
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

}