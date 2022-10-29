<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryProduct;

class ProductService
{

  use ApiResponser;

  function __construct(
  )
  {
  }

  public function getProducts(){
    try {
        $products = Product::select('products.id as id', 'products.name as product_name', 'products.unit_measurement_id', 'products.product_type_id', 'products.user_id', 'products.created_at',
                                    'unit_measurements.name as unit_measurement', 'product_types.name as product_type')
                        ->where('products.state', true)
                        ->where('products.user_id', Auth::user()->id)
                        ->join('users', 'users.id', '=', 'products.user_id')
                        ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                        ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                        ->get();
        return $this->successResponse($products);
    } catch (\Exception $e) {
        return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function inventoryProducts(){
    try {
        $query = Product::select('product_types.name as product_type', 'products.name as product_name',  'inventory_product.id as inventory_product_id',
                'inventory_product.amount as product_amount', 'inventory_product.unit_cost as product_unit_cost', 'inventory_product.total_cost as product_total_cost', 'inventories.date')
                ->where('inventory_product.state', true)
                ->where('products.state', true)
                ->where('inventories.state', true)
                ->where('products.user_id', Auth::user()->id)
                ->join('users', 'users.id', '=', 'products.user_id')
                ->join('inventories', 'inventories.user_id', '=', 'users.id')
                ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                ->join('inventory_product', function($join) {
                    $join->on('inventories.id', '=', 'inventory_product.inventory_id')
                    ->on('products.id', '=', 'inventory_product.product_id');
                })
                ->orderBy('date')
                ->get();
        return $this->successResponse($query);
    } catch (\Exception $e) {
        return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function totalInventaryByTypeProduct(){
      try {
        $query = Product::select('product_types.id as id', 'product_types.name as name',  'unit_measurements.name as unit_measurement', \DB::raw('SUM(inventory_product.amount) as total'))
                ->where('inventory_product.state', true)
                ->where('products.state', true)
                ->where('inventories.state', true)
                ->where('products.user_id', Auth::user()->id)
                ->join('users', 'users.id', '=', 'products.user_id')
                ->join('inventories', 'inventories.user_id', '=', 'users.id')
                ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                ->join('inventory_product', function($join) {
                    $join->on('inventories.id', '=', 'inventory_product.inventory_id')
                    ->on('products.id', '=', 'inventory_product.product_id');
                })
                ->groupBy('product_types.name', 'product_types.id', 'unit_measurements.name')
                ->get();
        return $this->successResponse($query);
      } catch (\Exception $e) {
        return $this->errorResponse(null, $e->getMessage(), 402);
      }
  }

  public function totalInventaryByProduct($product_type_id){
    try {
      $query = Product::select('products.id', 'products.name', 'products.total_amount','unit_measurements.name as unit_measurement')
                        ->where('products.product_type_id', $product_type_id)
                        ->where('products.user_id', Auth::user()->id)
                        ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                        ->get();
      /*$query = Product::select('products.id', 'products.name', 'unit_measurements.name as unit_measurement',\DB::raw('SUM(inventory_product.amount) as total'))
                                ->where('products.product_type_id', $product_type_id)
                                ->where('inventory_product.state', true)
                                ->where('products.state', true)
                                ->where('inventories.state', true)
                                
                                ->join('users', 'users.id', '=', 'products.user_id')
                                ->join('inventories', 'inventories.user_id', '=', 'users.id')
                                ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                                ->join('inventory_product', function($join) {
                                    $join->on('inventories.id', '=', 'inventory_product.inventory_id')
                                    ->on('products.id', '=', 'inventory_product.product_id');
                                })
                                ->groupBy('products.name', 'unit_measurements.name', 'products.id')
                                ->get();*/
      return $this->successResponse($query);
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function getDetailsProduct($product_id){
    try {
      $query = Product::find($product_id)->select('products.id', 'products.name', 'products.product_type_id','product_types.name as product_type_name', 
                        'products.unit_measurement_id','unit_measurements.name as unit_measurement_name',\DB::raw('SUM(inventory_product.amount) as total'))
                        ->where('inventory_product.state', true)
                        ->where('products.state', true)
                        ->where('inventories.state', true)
                        ->where('products.user_id', Auth::user()->id)
                        ->join('users', 'users.id', '=', 'products.user_id')
                        ->join('inventories', 'inventories.user_id', '=', 'users.id')
                        ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                        ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                        ->join('inventory_product', function($join) {
                          $join->on('inventories.id', '=', 'inventory_product.inventory_id')
                          ->on('products.id', '=', 'inventory_product.product_id');
                        })
                        ->groupBy('products.id', 'product_types.name', 'unit_measurements.name')
                        ->first();
      return $query;
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function getInventaryProduct($product_id){
    try {
      $query = Product::select('inventory_product.*', 'products.name', 'inventories.provider as inventory_provider', 'inventories.nit as inventory_nit', 'inventories.invoice_number as inventory_invoice_number',
                'products.product_type_id','product_types.name as product_type_name', 
                'products.unit_measurement_id','unit_measurements.name as unit_measurement_name')
                ->where('product_id', $product_id)
                ->where('inventory_product.state', true)
                ->where('products.state', true)
                ->where('inventories.state', true)
                ->where('products.user_id', Auth::user()->id)
                ->join('users', 'users.id', '=', 'products.user_id')
                ->join('inventory_product','products.id', '=', 'inventory_product.product_id')
                ->join('inventories', 'inventories.id', '=', 'inventory_product.inventory_id')
                ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                ->get();
      return $query;
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function getProductsByProductType($product_type_id){
    try {
      $query = Product::select('products.*', 'products.product_type_id','product_types.name as product_type_name', 
                      'products.unit_measurement_id','unit_measurements.name as unit_measurement_name')
                      ->where('product_type_id', $product_type_id)
                      ->where('products.state', true)
                      ->where('products.user_id', Auth::user()->id)
                      ->join('unit_measurements', 'unit_measurements.id', '=', 'products.unit_measurement_id')
                      ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                      ->get();
      return $query;
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 402);
    }
  }

  public function deleteProduct($product_id){
    \DB::beginTransaction();
    try {
      if(is_null($product = Product::find($product_id))){
        return $this->errorResponse(null, 'Product not found', 404);
      }
      $product->state = false;
      $product->save();
      $inventories = InventoryProduct::where('product_id', $product_id)->get();
      foreach ($inventories as $key => $inventory) {
        $inventory->state = false;
        $inventory->save();
      }
      \DB::commit();
      return $this->successResponse(null, 'Producto eliminado correctamente');
    } catch (\Exception $e) {
      \DB::rollback();
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function deleteInventory($inventory_id){
    \DB::beginTransaction();
    try {
      if(is_null($inventory = Inventory::find($inventory_id))){
        return $this->errorResponse(null, 'Inventory not found', 404);
      }
      $inventory->state = false;
      $inventory->save();
      $products = InventoryProduct::where('inventory_id', $inventory_id)->get();
      foreach ($products as $key => $product) {
        $product->state = false;
        $product->save();
      }
      \DB::commit();
      return $this->successResponse(null, 'Inventario eliminado correctamente');
    } catch (\Exception $e) {
      \DB::rollback();
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }
}