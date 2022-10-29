<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Services\ProductService;

class InventoryAndProductController extends ApiController
{
    private $product_service;

    public function __construct(
        ProductService $product_service
    )
    {
        $this->product_service = $product_service;
    }
    //
    public function createProduct(ProductRequest $request)
    {
        try {
            $costs = [
                'total_amount' => 0
            ];
            $product = Auth::user()->products()->create(array_merge($request->all(), $costs));
            return $this->successResponse($product, 'Se ha creado correctamente el producto', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 402);
        }
    }

    public function updateProduct(ProductRequest $request, $product_id)
    {
        try {
            $product = Auth::user()->products()->find($product_id);
            if(is_null($product)){
                return $this->errorResponse(null, 'Product not found', 404);
            }
            $product->update($request->all());
            return $this->successResponse($product, 'Se ha actualizado correctamente el producto', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 402);
        }
    }
    
    public function createInventory(Request $request)
    {
        try {
            $inventory = Auth::user()->inventories()->create($request->all());
            if($request->inventory_products){
                foreach ($request->inventory_products as $key => $value) {
                    $inventory->products()->attach($value['product_id'], ['amount' => $value['amount'],
                                            'unit_cost' => $value['unit_cost'], 'total_cost' => $value['total_cost']]);
                    $product = Product::find($value['product_id']);
                    $product->total_amount += $value['amount'];
                    $product->save();
                }
            }
            return $this->successResponse($inventory, 'Se ha creado correctamente el inventario', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 402);
        }
    }

    public function listProducts(){
        return $this->product_service->getProducts();
    }

    public function getDetailsProduct($product_id){
        
        return $this->product_service->getDetailsProduct($product_id);//Product::find($product_id);
        /*try {
            if(is_null($product)){
                return $this->errorResponse(null, 'Product not found', 404);
            }
            return $this->successResponse($product);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 402);
        }*/
    }

    public function inventoryProducts(){
        return $this->product_service->inventoryProducts();
    }

    public function totalInventaryByTypeProduct(){
        return $this->product_service->totalInventaryByTypeProduct();
    }

    public function totalInventoryByProduct($product_type_id){
        return $this->product_service->totalInventaryByProduct($product_type_id);
    }

    public function getInventaryProduct($product_id){
        return $this->product_service->getInventaryProduct($product_id);
    }

    public function getProductsByProductType($product_type_id){
        return $this->product_service->getProductsByProductType($product_type_id);
    }

    public function deleteProduct($product_id){
        return $this->product_service->deleteProduct($product_id);
    }

    public function deleteInventory($inventory_id){
        return $this->product_service->deleteInventory($inventory_id);
    }
}
