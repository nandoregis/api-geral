<?php

namespace app\Factory;

use Exception;

class Href
{

    private $dataLink = [];
    private string $_key;
    private $_title;
    private $_href;

    public function new(String $key) : self
    {

        if(!isset($key)) throw new Exception("Não foi setado um valor chave", 1);
        if(!preg_match('/^[a-z]+$/', $key)) throw new Exception("Somente é permitido texto", 1);      
        
        $this->_key = $key;

        if(isset($this->dataLink[$key])) {
            throw new Exception("Já existe item com essa chave", 1);
        }
        
        $this->dataLink[$key] = [];

        return $this;

    }

    public function name(String $key)
    {
        if(!isset($this->dataLink[$key])) {
            throw new Exception("Não existe item com essa chave", 1);
        }

        $this->_key =  $key;

        return $this;
    }

    public function get(String $key) 
    {
        if(!isset($this->dataLink[$key])) {
            throw new Exception("Não existe item com essa chave", 1);
        }

        return $this->dataLink[$key];
    }

    public function get_all()
    {
        return $this->dataLink;
    }

    public function href(String $title, String $href)
    {
        if(!isset($this->_key) ) throw new Exception("Não foi setado um valor chave", 1);
        if(!isset($title) || !isset($href) ) throw new Exception("Falta titulo ou href", 1);

        $this->_title = $title;
        $this->_href = $href;

        $link = [
            'title' => $this->_title,
            'href' =>  $this->_href
        ];

        array_push($this->dataLink[$this->_key], $link);
        
        return $this;
    }

   
}