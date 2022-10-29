<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\TypeCost;
use App\Models\TypeActivity;
use App\Models\TypeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ReportController extends ApiController
{
    public function costs(Request $request){
        $type_cost = TypeCost::find($request->type_cost_id);
        if($type_cost->description === 'Actividad') {
            $costs = TypeActivity::select('costs.id', 'costs.amount','costs.unit_cost', 'type_activities.id as tiype_activity_id','type_activities.description', Cost::raw('sum(costs.amount * costs.unit_cost) as total'));
                            //->where('farm_id', $request->farm_id);

            $costs->leftJoin('costs', function($join) use ($request) {
                $join->on('costs.type_activity_id', '=', 'type_activities.id');
                $join->where('farm_id', $request->farm_id);
                if($request->lot_id){
                    $join->where('lot_id', $request->lot_id);
                }
                if($request->initial_date){
                    $join->whereDate('costs.created_at', '>=', $request->initial_date);
                }
                if($request->final_date){
                    $join->whereDate('costs.created_at', '<=', $request->final_date);
                }
            })->groupBy('costs.id', 'type_activities.description', 'type_activities.id');
        } else if($type_cost->description === 'Administrativo') {
            $costs = TypeCategory::select('costs.id', 'costs.amount','costs.unit_cost', 'type_categories.id as type_category_id', 'type_categories.description', Cost::raw('sum(costs.amount * costs.unit_cost) as total'));
                            //->where('farm_id', $request->farm_id);

            $costs->leftJoin('costs', function($join) use ($request) {
                $join->on('costs.type_category_id', '=', 'type_categories.id');
                $join->where('farm_id', $request->farm_id);
                if($request->initial_date){
                    $join->whereDate('costs.created_at', '>=', $request->initial_date);
                }
                if($request->final_date){
                    $join->whereDate('costs.created_at', '<=', $request->final_date);
                }
            })->groupBy('costs.id', 'type_categories.description', 'type_categories.id');
        }

        return $this->successResponse($costs->get());
    }

    public function lastRegisters(Request $request) {
        if(!isset($request->type_cost_id)) {
            return $this->errorResponse(null, 'El campo tipo de costo es obligatorio', 400);
        }
        $type_cost = TypeCost::find($request->type_cost_id);
        if($type_cost->description === 'Actividad') {
            $costs = Cost::select('costs.*','type_activities.description as type_activity', Cost::raw('sum(costs.amount * costs.unit_cost) as total'))->where('costs.type_cost_id', $type_cost->id)
                            ->join('type_activities', 'type_activities.id', '=', 'costs.type_activity_id')
                            ->groupBy('costs.id', 'type_activities.description');
        } else if($type_cost->description === 'Administrativo') {
            $costs = Cost::select('costs.*','type_categories.description as type_category', Cost::raw('sum(costs.amount * costs.unit_cost) as total'))->where('costs.type_cost_id', $type_cost->id)
                            ->join('type_categories', 'type_categories.id', '=', 'costs.type_category_id')
                            ->groupBy('costs.id', 'type_categories.description');
        }

        return $this->successResponse($costs->latest()->take(5)->get());
    }
}
