<?php

namespace app\Modules\Produtos\Controller;

use app\Core\HttpCode;
use app\Factory\Response;
use app\Modules\Produtos\Helper\ProductHelper;
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
     
        $reference = $req->input('reference','');
        $name = $req->input('name','');
        $variations = $req->input('variations',[]);
        
        $this->productValidator->validateReference($reference);
        $this->productValidator->validateName($name);
        $this->productValidator->validateArrayVariations($variations);

        if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        // verificões de UUID das tabelas sizes e colors
        for ($i=0; $i < count($variations); $i++) 
        { 
            $size_uuid = isset($variations[$i]['size_uuid']) ? $variations[$i]['size_uuid'] : "";
            $color_uuid = isset($variations[$i]['color_uuid']) ? $variations[$i]['color_uuid'] : "";
            $price = isset($variations[$i]['price']) ? $variations[$i]['price'] : "";

            if(!$this->getterProdutosModel->getSizeByUUID($size_uuid)) {
                return Response::error(HttpCode::CONFLICT, "Não foi possivel identicar esse tamanho, verificar o uuid do tamanho");
            }
    
            if(!$this->getterProdutosModel->getColorByUUID($color_uuid) ) {
                return Response::error(HttpCode::CONFLICT, "Não foi possivel identicar essa cor, verificar o uuid da cor");
            }

            $this->productValidator->validatePrice($price);
            $variations[$i]['price'] = ProductHelper::price_format($price);

        }

        if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        if( $this->getterProdutosModel->getByReference($reference) ) 
        {   
            return Response::error(HttpCode::CONFLICT, "Já existe um produto com essa referência");
        }

        $result = $this->setterProdutosModel->create($reference, $name, $variations);

        if(!$result) return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para criar o produto");
        
        return Response::success(HttpCode::CREATED, "Produto criado com sucesso" ,$result);

    }

    public function update(object $req)
    { 
        
        $uuid = $req->uri('uuid','');
        $reference = $req->input('reference','');
        $name = $req->input('name','');
        
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

    //=========================================================================
    //                          product_variations          
    //=========================================================================

    public function createProductVariations(object $req) {
        
        $product_uuid = $req->input('product_uuid','');
        $variations = $req->input('variations', []);

        $this->productValidator->validateArrayVariations($variations);
        $this->productValidator->validateUUID($product_uuid);

        foreach ($variations as $key => $value) 
        {       
            $size_uuid = isset($value['size_uuid']) ? $value['size_uuid'] : "";
            $color_uuid = isset($value['color_uuid']) ? $value['color_uuid'] : "";
            $price = isset($value['price']) ? $value['price'] : "";
            
            $this->productValidator->validateUUID($size_uuid);
            $this->productValidator->validateUUID($color_uuid);
            $this->productValidator->validatePrice($price);

            $value['price'] = ProductHelper::price_format($value['price']);

            if($this->getterProdutosModel->getProductVariationByUUIDSizeandUUDColor($product_uuid,$size_uuid, $color_uuid)) {
                return Response::error(HttpCode::CONFLICT, [
                    'error'=> "Já existe uma variação com esse tamanho e cor.",
                    'field'=> $value,
                ]);
            }
        }

        if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        $result = $this->setterProdutosModel->createProductVariations($product_uuid, $variations);

        if(!$result) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para criar as variações do produto");
        }

        return Response::success(HttpCode::CREATED, "Produto atualizado com sucesso" , $result);
        
    }

    public function updatePriceProductVariation(object $req) {

        $product_uuid = $req->input('product_uuid','');
        $variations = $req->input('variations', []);

        $this->productValidator->validateArrayVariations($variations);

        $this->productValidator->validateUUID($product_uuid);

        foreach ($variations as $key => $value) 
        {   
            $this->productValidator->validateUUID($value['variation_uuid']);
            $this->productValidator->validatePrice($value['price']);
        
            $value['price'] = ProductHelper::price_format($value['price']);
            
        }

        if ($this->productValidator->hasErrors()) 
        {   
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        $result = $this->setterProdutosModel->updatePriceProductVariation($product_uuid, $variations);

        if($result) {
            return Response::success(HttpCode::CREATED, "Preço do produto alterado com sucesso" , $result);
        }

    }

    //=========================================================================
    //
    //                                 SALES          
    //
    //=========================================================================
 
    public function newSale(object $req) : array
    {
       
        $user_uuid = isset($req->authTokenDecoded) ? $req->authTokenDecoded['uuid'] : "";
        $this->productValidator->validateUUID($user_uuid);

        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        // validar se usuario existe. ( mas basicamente é o mesmo usuario que está fazendo a venda PDV)

        $result = $this->setterProdutosModel->newSale($user_uuid);

        if(!$result) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para criar nova venda");
        } 

        return Response::success(HttpCode::CREATED, "Nova venda criada!", $result);
    }

    public function addProductInSale(object $req) 
    {

        $sale_uuid = $req->input('sale_uuid','');
        $product_uuid = $req->input('product_uuid','');
        $variations = $req->input('variations',[]); // is array
        $variationsFromUpdate = [];
        $variationsFromInsert = [];
        $insertResult = [];
        $updateResult = [];

        $this->productValidator->validateUUID($sale_uuid);
        $this->productValidator->validateUUID($product_uuid);
        $this->productValidator->validateArrayVariations($variations);

        foreach ($variations as $key => $value) 
        {   
        
            $this->productValidator->validateUUID($value['variation_uuid']);
            $this->productValidator->validateQuantity($value['quantity']);
            $this->productValidator->validatePrice($value['price']);
            
            $value['price'] = ProductHelper::price_format($value['price']);
            $value['quantity'] = (int) $value['quantity'];

            $existing = $this->getterProdutosModel->getSaleItemsBySaleUUIDVariationUUID($sale_uuid, $value['variation_uuid'], $value['price']);

            if($existing) {
                $variationsFromUpdate[] = $value;
            } else {
                $variationsFromInsert[] = $value;
            }
        }
        
        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        if( $variationsFromInsert ){
            $insertResult = $this->setterProdutosModel->addProductsInSale($sale_uuid, $product_uuid, $variationsFromInsert);
        }

        if( $variationsFromUpdate ) {
            $updateResult = $this->setterProdutosModel->updateProductsInSale($sale_uuid, $variationsFromUpdate);
        }

        if(!$insertResult && $variationsFromInsert) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para adicionar item na venda");
        }

        if( !$updateResult && $variationsFromUpdate ) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para atualizar item na venda");
        }

        $saleProducts = $this->getterProdutosModel->getSaleItemsBySaleUUID($sale_uuid);

        if(empty($saleProducts)) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR,'Está voltando vazial na busca, mas tem produto');
        }

        return Response::success(HttpCode::CREATED, "Itens da venda", $saleProducts);
            
    }

    public function updateProductInSale(object $req) {

        $uuid = $req->input('uuid','');
        $quantity = $req->input('quantity',0);
        $price = $req->input('price','');

        $this->productValidator->validateUUID($uuid);
        $this->productValidator->validateQuantity($quantity);
        $this->productValidator->validatePrice($price);

        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }
        
        $result = $this->setterProdutosModel->updateProductInSale($uuid, $quantity, $price);

        if(!$result) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para atualizar o produto na venda");
        }

        return Response::success(HttpCode::OK, "Produto atualizado na venda", $result);
    }

    public function finishSale(object $req) {

        $uuid = $req->uri('uuid','');
        $payment = $req->input('payment','');

        $this->productValidator->validateUUID($uuid);
        $this->productValidator->validateName($payment);

        if ($this->productValidator->hasErrors()) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }
         
        $sale = $this->getterProdutosModel->getSaleByUUID($uuid);
        $saleItems = $this->getterProdutosModel->getSaleItemsBySaleUUID($uuid);

        if($payment === 'pendente'){
            return Response::error(HttpCode::UNAUTHORIZED,'Venda não pode finalizar com opção de pagamento pendente');
        }

        if(empty($saleItems)) return Response::error(HttpCode::NOT_FOUND, "Venda não pode fechar sem produtos");

        if( isset($sale) ) {
            if($sale['status'] == 1) return Response::error(HttpCode::UNAUTHORIZED, 'Venda já finalizada');
        }
        
        foreach ($saleItems as $key => $value) 
        {   
            $quantity =  isset($value['quantity']) ? (int) $value['quantity'] : "";
            $variation_uuid = isset($value['variation_uuid']) ? $value['variation_uuid'] : "";
           
            $quantityStock = $this->getterProdutosModel->getStockByVariationUUID($variation_uuid); 

            if(empty($quantityStock)) {
                return Response::error(HttpCode::NOT_FOUND,"Não existe produto em estoque com essa variação");
                break;
            }

            if( $quantity > $quantityStock['quantity']) {
                return Response::error(HttpCode::UNAUTHORIZED,"Quantidade maior do que existente em estoque");
                break;
            }
        }

        $result = $this->setterProdutosModel->finishSale($uuid);

        if(!$result) {
            return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para finalizar a venda");
        }

        return Response::success(HttpCode::OK, "Venda finalizada", $result);
    }

    //=========================================================================
    //
    //                                 STOCK          
    //
    //=========================================================================

    public function stockProductIn(object $req) {
        $product_uuid = $req->input('product_uuid', '');
        $variations = $req->input('variations', []);

        if($this->hasErrosProductStock($req)) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        $result = $this->setterProdutosModel->entryVariationsProductInStock($product_uuid, $variations);

        if(!$result) {
           return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para entrada no estoque");
        }

        return Response::success(HttpCode::CREATED, "Entrada no estoque", $result);
    }

    public function stockProductOut(object $req) {
        
        $product_uuid = $req->input('product_uuid', '');
        $variations = $req->input('variations', []);

        if($this->hasErrosProductStock($req)) {
            return Response::error(HttpCode::UNAUTHORIZED, $this->productValidator->getErrors());
        }

        $result = $this->setterProdutosModel->exitVariationsProductInStock($product_uuid, $variations);

        if(!$result) {
           return Response::error(HttpCode::INTERNAL_SERVER_ERROR, "Houve um erro para saída no estoque");
        }

        return Response::success(HttpCode::CREATED, "Saida do estoque", $result); 
        
    }

    private function hasErrosProductStock(object $req)
    {
        $product_uuid = $req->input('product_uuid', '');
        $variations = $req->input('variations', []);

        $this->productValidator->validateUUID($product_uuid);
        $this->productValidator->validateArrayVariations($variations);

        foreach ($variations as $key => $value) 
        {
            $uuid = isset($value['uuid']) ? $value['uuid'] : "";
            $quantity = isset($value['quantity']) ? $value['quantity'] : "";

            $this->productValidator->validateUUID($uuid);
            $this->productValidator->validateQuantity($quantity);
        }

        return $this->productValidator->hasErrors();
        
    }
    
    //=========================================================================
    //
    //                                 SIZES          
    //
    //=========================================================================

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


}