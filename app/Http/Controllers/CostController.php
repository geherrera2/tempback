<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CostService;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CostRequest;
use App\Models\Cost;
use App\Models\TypeCost;

class CostController extends ApiController
{
    private $cost_service;
    public function __construct(CostService $cost_service){
        $this->cost_service = $cost_service;
    }
    
    public function create(CostRequest $request){
        try {
            return $this->cost_service->create($request);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function getTypeCosts(){
        return $this->cost_service->getTypeCosts();
    }

    public function getTypeCategories(){
        return $this->cost_service->getTypeCategories();
    }

    public function getTypeActivities(){
        return $this->cost_service->getTypeActivities();
    }

    public function getStages(){
        return $this->cost_service->getStages();
    }

    public function getTypeWorks(){
        return $this->cost_service->getTypeWorks();
    }

    public function getCostAdministrative(){
        return $this->cost_service->getCostAdministrative();
    }

    public function getCostAdministrativeDetails($type_category_id){
        return $this->cost_service->getCostAdministrativeDetails($type_category_id);
    }

    public function getCostActivity(){
        return $this->cost_service->getCostActivity();
    }

    public function getCostActivityDetails($type_activity_id){
        return $this->cost_service->getCostActivityDetails($type_activity_id);
    }

    public function detailsByActivity($activity_id){
        try {
            $type_cost = TypeCost::where('description', 'Actividad')->first();

            $costs = Cost::where('type_cost_id', $type_cost->id)->where('type_activity_id', $activity_id)->get();
            $total = Cost::select(Cost::raw('sum(amount * unit_cost) as total'))->where('type_activity_id', $activity_id)->groupBy('id')->get();
            //dd($total);
            return $this->successResponse(['costs' => $costs, 'total' => $total]);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 400);
        }
    }

    public function detailsByAdministrative($type_category_id){
        try {
            $type_cost = TypeCost::where('description', 'Administrativo')->first();

            $costs = Cost::where('type_cost_id', $type_cost->id)->where('type_category_id', $type_category_id)->get();
            $total = Cost::select(Cost::raw('sum(amount * unit_cost) as total'))->where('type_category_id', $type_category_id)->groupBy('id')->get();
            //dd($total);
            return $this->successResponse(['costs' => $costs, 'total' => $total]);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 400);
        }
    }
}
