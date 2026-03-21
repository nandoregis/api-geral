<?php

namespace app\Modules\Produtos\Controller;

use app\Core\HttpCode;
use app\Factory\Response;
use app\Modules\Produtos\Model\GetterProdutosModel;
use app\Modules\Produtos\Model\SetterProdutosModel;
use app\Modules\Produtos\Validator\ProductValidator;

class SetterProdutosController
{
    private $productValidator;
    private $setterProdutosModel;
    private $getterProdutosModel;
    public function __construct() 
    {
       $this->setterProdutosModel = new SetterProdutosModel;
       $this->getterProdutosModel = new GetterProdutosModel;
       $this->productValidator = new ProductValidator;
    }

    public function create(object $req)
    {   
        // size:uuid, color_uuid ( validar e verificar no db)
        // price, input = 45,55  ( validar e formatar) output 45.55
        $reference = $req->input('reference');
        $name = $req->input('name');
        $size_uuid = $req->input('size_uuid');
        $color_uuid = $req->input('color_uuid');
        $price = $req->input('price');
        
        $this->productValidator->validateReference($reference);
        $this->productValidator->validateName($name);
        $this->productValidator->validateUUID($size_uuid);
        $this->productValidator->validateUUID($color_uuid);
        $this->productValidator->validatePrice($price);

        if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        if( $this->getterProdutosModel->getByReference($reference) ) 
        {   
            return Response::error(HttpCode::CONFLICT, "Já existe um produto com essa referência");
        }

        // validar UUIDs se existem

        if(!$this->getterProdutosModel->getSizeByUUID($size_uuid)) {
            return Response::error(HttpCode::CONFLICT, "Não foi possivel identicar esse tamanho");
        }

        if(!$this->getterProdutosModel->getColorByUUID($color_uuid) ) {
            return Response::error(HttpCode::CONFLICT, "Não foi possivel identicar essa cor");
        }

        $result = $this->setterProdutosModel->create($reference, $name);

        if(!$result) return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para criar o produto");
        
        return Response::success(HttpCode::CREATED, "Produto criado com sucesso" ,$result);

    }

    public function update(object $req)
    { 
        
        $uuid = $req->input('uuid');
        $reference = $req->input('reference');
        $name = $req->input('name');
        
        $this->productValidator->validateUUID($uuid);
        $this->productValidator->validateName($name);
        $this->productValidator->validateReference($reference);

         if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        if( $this->getterProdutosModel->checkReferenceWithDifferentUUID($uuid, $reference) ) 
        {
            return Response::error(HttpCode::CONFLICT, "Já existe um produto com essa referência");
        }
        
        $result = $this->setterProdutosModel->update($uuid, $reference, $name);

        if(!$result) return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para atualizar o produto");

        return Response::success(HttpCode::OK, "Produto atualizado com sucesso" ,$result);

    }

    public function delete(string $uuid) {}

    public function saleProducts() {}

    public function stockProductEntry() {}

    public function stockProductExit() {}

    public function createSize(object $req) 
    {
    
        $name = $req->input('name');
        
        $this->productValidator->validateNameSize($name);

        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        // verificar se tem item de tamanho com mesmo nome. ( não permitir );

        if($this->getterProdutosModel->getSizeByName($name)) {
            return Response::error(HttpCode::CONFLICT, "Já existe um tamanho com esse nome");
        }

        $result = $this->setterProdutosModel->createSize($name);

        if(!$result){
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um problema para criar o tamanho");
        }

        return Response::success(HttpCode::CREATED, "Tamanho criado com sucesso", $result);
        
    }

    public function createColors(object $req) {

        $name = $req->input('name');
        $color_hex = $req->input('color_hex');
        
        $this->productValidator->validateName($name);
        $this->productValidator->validateColorHex($color_hex);

        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        if ($this->getterProdutosModel->getColorByName($name)) {
            return Response::error(HttpCode::CONFLICT, "Já existe uma cor com esse nome");
        }

        $result = $this->setterProdutosModel->createColors($name, $color_hex);

        if(!$result) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um problema para criar a cor");
        }

        return Response::success(HttpCode::CREATED, "Cor criada com sucesso", $result);
    }

    public function createProductVariations() {}

}