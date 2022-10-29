<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Farm;
use App\Models\Lot;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\SaleRequest;
use App\Models\TypeCoffeeSale;

class SalesController extends ApiController
{
    public function create(SaleRequest $request){
        try {
            if(is_null($farm = Farm::where('state', true)->find($request->farm_id))){
                throw new ModelNotFoundException('Farm not found');
            }
            if(is_null($lot = Lot::where('state', true)->find($request->lot_id))){
                throw new ModelNotFoundException('Lot not found');
            }
            $sale = Sale::create($request->all());
            return $this->successResponse($sale, 'Venta creada correctamente', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function index(Request $request, $farm_id, $lot_id){
        try {
            $sales = Sale::where('sales.farm_id',$farm_id)->where('sales.lot_id', $lot_id)
                            ->where('farms.user_id', Auth::user()->id)
                            ->join('farms', 'farms.id', '=', 'sales.farm_id');
            if($request->initial_date){
                $sales->whereDate('sales.date', '>=', $request->initial_date);
            }
            if($request->final_date){
                $sales->whereDate('sales.date', '<=', $request->final_date);
            }
            $total = Sale::select(\DB::raw('SUM(sales.sale_value) as total'))->where('sales.farm_id',$farm_id)->where('sales.lot_id', $lot_id)
                            ->where('farms.user_id', Auth::user()->id)
                            ->join('farms', 'farms.id', '=', 'sales.farm_id');
            if($request->initial_date){
                $total->whereDate('sales.date', '>=', $request->initial_date);
            }
            if($request->final_date){
                $total->whereDate('sales.date', '<=', $request->final_date);
            }

            return $this->successResponse([
                'data' => $sales->get(),
                'total' => $total->get()
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function typeCoffeeSale() {
        try {
            return $this->successResponse(TypeCoffeeSale::get());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }
}
