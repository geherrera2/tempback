<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FarmRequest;
use App\Http\Requests\LotRequest;
use App\Models\Farm;
use App\Models\Lot;
use App\Services\FarmService;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InsufficientAmount;

class FarmController extends ApiController
{

    private $farm_service;

    public function __construct(
        FarmService $farm_service
    )
    {
        $this->farm_service = $farm_service;
    }

    public function index()
    {
        try {
            return $this->successResponse(Auth::user()->farms()->select('farms.id', 'farms.name')->where('state', true)->get());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function indexLots($id_farm)
    {
        try {
            if(!is_null($farm = Farm::where('state', true)->where('id',$id_farm)->first())){
                return $this->successResponse($farm->lots()->select('lots.id','lots.name', 'lots.total_area')->where('state', true)->get());
            } else {
                return $this->errorResponse(null, 'Farm not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }
    
    public function create(FarmRequest $request)
    {
        try {
            \DB::beginTransaction();
            $data = $request->all();
            $data['available_area'] = $request->get('total_area');
            $farm = Auth::user()->farms()->create($data);
            \Log::info('Success farm create: ' . $farm->name . ' with id: ' . $farm->id);
            \DB::commit();
            return $this->successResponse($farm, 'Finca creada correctamente', 201);
        } catch (\Exception $e) {
            \Log::critical('Error farm create: ' . $request->name);
            \DB::rollback();
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function createLot(LotRequest $request)
    {
        try {
            \DB::beginTransaction();
            if(is_null($farm = Farm::where('state', true)->find($request->farm_id))){
                return $this->errorResponse(null, 'Farm not found', 404);
            }
            if($farm->available_area < $request->get('total_area')){
                throw new InsufficientAmount("El total del area del lote no puede ser mayor al total de area disponible.");
            }
            $lot = Lot::create($request->all());
            $farm->available_area -= $lot->total_area;
            $farm->save();
            \Log::info('Success lot create: ' . $lot->name . ' with id: '. $lot->id);
            \DB::commit();
            return $this->successResponse($lot, 'Lote creado correctamente', 201);
        } catch (\Exception $e) {
            \Log::critical('Error lot create: ' . $request->name);
            \DB::rollback();
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function detailsLot($id_lot)
    {
        try {
            return $this->farm_service->getDetailsLot($id_lot);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function details($id_farm)
    {
        try {
            return $this->farm_service->getDetails($id_farm);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function update(FarmRequest $request, $id_farm)
    {
        try {
            if(!is_null($farm = Farm::where('state', true)->find($id_farm))){

                $lots_area = $farm->total_area - $farm->available_area;

                if($request->get('total_area') < $lots_area){
                    throw new InsufficientAmount("El total del área de la finca no puede ser menor a la suma total del área de los lotes.");
                }
                $farm->update($request->all());
                $farm->available_area = $farm->total_area - $lots_area;
                $farm->update();
                return $this->successResponse($farm);
            } else {
                return $this->errorResponse(null, 'Farm not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function updateLot(LotRequest $request, $id_lot)
    {
        try {
            \DB::beginTransaction();
            if(!is_null($lot = Lot::where('state', true)->find($id_lot))){
                $farm = Farm::find($lot->farm_id);
                $farm->available_area += $lot->total_area;
                if($farm->available_area < $request->total_area){
                    throw new InsufficientAmount("El total del area del lote no puede ser mayor al total de area disponible.");
                }
                $farm->save();
                $lot->update($request->all());
                $farm->available_area -= $lot->total_area;
                $farm->save();
                \DB::commit();
                return $this->successResponse($lot);
            } else {
                \DB::rollback();
                return $this->errorResponse(null, 'Lot not found', 404);
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function delete($farm_id){
        return $this->farm_service->deleteFarm($farm_id);
    }

    public function deleteLot($lot_id){
        return $this->farm_service->deleteLot($lot_id);
    }

    public function deleteAnalysis($analysis_id){
        return $this->farm_service->deleteAnalysis($analysis_id);
    }
}
