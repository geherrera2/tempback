<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use App\Models\Cost;
use App\Models\Supplie;
use App\Models\TypeCost;
use App\Models\TypeCategory;
use App\Models\TypeActivity;
use App\Models\TypeWork;
use App\Models\Stage;
use App\Models\Product;
use App\Exceptions\InsufficientAmount;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CostService
{

  use ApiResponser;

  function __construct(
  )
  {
  }

  public function create($request){
    \DB::beginTransaction();
    try {
      $cost = Cost::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
      if(TypeCost::find($request->type_cost_id)->description === 'Actividad') {
        foreach ($request->supplies as $key => $value) {
          $product = Product::find($value['product_id']);
          if(is_null($product = Product::find($value['product_id']))){
            throw new ModelNotFoundException("Product not found");
          }
          if($product->total_amount === 0 || $product->total_amount - $value['amount'] < 0) {
            throw new InsufficientAmount("La cantidad ha descontar del producto es mayor a la cantidad de producto actual en inventario.");
          }
          $supplie = Supplie::create(array_merge($value, ['cost_id' => $cost->id]));
          $supplie->costs()->attach($cost->id);
          $product->total_amount -= $value['amount'];
          $product->save();
        }

      }
      \DB::commit();
      return $this->successResponse($cost, 'Se ha creado correctamente el costo', 200);
    } catch (\Exception $e) {
      \DB::rollback();
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getTypeCosts(){
    try {
      return $this->successResponse(TypeCost::all());
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getTypeCategories(){
    try {
      return $this->successResponse(TypeCategory::all());
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getTypeActivities(){
    try {
      return $this->successResponse(TypeActivity::all());
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getStages(){
    try {
      return $this->successResponse(Stage::all());
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getTypeWorks(){
    try {
      return $this->successResponse(TypeWork::all());
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getCostAdministrative(){
    try {
      $type_cost = TypeCost::where('description', 'Administrativo')->first();
      return Cost::select('type_categories.id','type_categories.description', \DB::raw('SUM(costs.unit_cost) as total'))
                  ->where('costs.type_cost_id', $type_cost->id)
                  ->where('farms.user_id', Auth::user()->id)
                  ->join('farms', 'farms.id', '=', 'costs.farm_id')
                  ->join('type_categories', 'type_categories.id', '=', 'costs.type_category_id')
                  ->groupBy('type_categories.id', 'type_categories.description')
                  ->get();
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getCostAdministrativeDetails($type_category_id){
    try {
      $type_cost = TypeCost::where('description', 'Administrativo')->first();
      return Cost::select('costs.*', 'type_categories.description as category_description', 'farms.name as farm_name', 'stages.description as stage_description')
                  ->where('costs.type_cost_id', $type_cost->id)
                  ->where('farms.user_id', Auth::user()->id)
                  ->where('type_categories.id', $type_category_id)
                  ->join('farms', 'farms.id', '=', 'costs.farm_id')
                  ->join('stages', 'stages.id', '=', 'costs.stage_id')
                  ->join('type_categories', 'type_categories.id', '=', 'costs.type_category_id')
                  ->get();
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getCostActivity(){
    try {
      $type_cost = TypeCost::where('description', 'Actividad')->first();
      return Cost::select('type_activities.id', 'type_activities.description as type_activities_name', \DB::raw('SUM(costs.unit_cost) as total'))
                  ->where('costs.type_cost_id', $type_cost->id)
                  ->where('products.user_id', Auth::user()->id)
                  ->where('products.state', true)
                  ->join('type_activities', 'type_activities.id', '=', 'costs.type_activity_id')
                  ->join('cost_supplie', 'cost_supplie.cost_id', '=', 'costs.id')
                  ->join('supplies', 'supplies.id', '=', 'cost_supplie.supplie_id')
                  ->join('products', 'products.id', '=', 'supplies.product_id')
                  ->groupBy('type_activities.id', 'type_activities.description')
                  ->get();
    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getCostActivityDetails($type_activity_id){
    try {
      $type_cost = TypeCost::where('description', 'Actividad')->first();
      $costs = Cost::select('costs.*', 'farms.name as farm_name', 'lots.name as lot_name', 'stages.description as stage_name',
                  'type_works.description as type_work_name', 'type_activities.description as type_activities_name')
                  ->where('costs.type_cost_id', $type_cost->id)
                  ->where('products.user_id', Auth::user()->id)
                  ->where('products.state', true)
                  ->where('type_activities.id', $type_activity_id)
                  ->join('farms', 'farms.id', '=', 'costs.farm_id')
                  ->join('lots', 'lots.id', '=', 'costs.lot_id')
                  ->join('stages', 'stages.id', '=', 'costs.stage_id')
                  ->join('type_works', 'type_works.id', '=', 'costs.type_work_id')
                  ->join('type_activities', 'type_activities.id', '=', 'costs.type_activity_id')
                  ->join('cost_supplie', 'cost_supplie.cost_id', '=', 'costs.id')
                  ->join('supplies', 'supplies.id', '=', 'cost_supplie.supplie_id')
                  ->join('products', 'products.id', '=', 'supplies.product_id')
                  ->get();
      
      $total = Cost::select(\DB::raw('SUM(costs.unit_cost) as total'))
                          ->where('costs.type_cost_id', $type_cost->id)
                          ->where('products.user_id', Auth::user()->id)
                          ->where('products.state', true)
                          ->where('type_activities.id', $type_activity_id)
                          ->join('cost_supplie', 'cost_supplie.cost_id', '=', 'costs.id')
                          ->join('supplies', 'supplies.id', '=', 'cost_supplie.supplie_id')
                          ->join('products', 'products.id', '=', 'supplies.product_id')
                          ->join('type_activities', 'type_activities.id', '=', 'costs.type_activity_id')
                          ->get();

      return [
        'costs' => $costs,
        'total' => $total
      ];

    } catch (\Exception $e) {
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function getDetails($id_farm){
    if(!is_null($farm = Farm::where('state', true)->find($id_farm))){
        return $this->successResponse($farm->select('farms.*', 'departments.name as department', 'municipalities.name as municipality', 'villages.name as village', 'holdings.description as holding')
                                            ->join('departments', 'departments.id' , '=' , 'farms.department_id')
                                            ->join('municipalities', 'municipalities.id' , '=' , 'farms.municipality_id')
                                            ->join('villages', 'villages.id' , '=' , 'farms.village_id')
                                            ->join('holdings', 'holdings.id' , '=' , 'farms.holding_id')
                                            ->where('farms.id',$id_farm)
                                            ->first());
    } else {
        return $this->errorResponse(null, 'Farm not found', 404);
    }
  }
}
