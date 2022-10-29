<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use App\Models\Farm;
use App\Models\Lot;
use App\Models\SoilAnalysis;

class FarmService
{

  use ApiResponser;

  function __construct(
  )
  {
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

  public function getDetailsLot($id_lot){
    if(!is_null($lot = Lot::where('state', true)->find($id_lot))){
        return $this->successResponse($lot->select('lots.*', 'varietie_coffees.description as varietie_coffee', 'renewals.description as renewal', 'type_renewals.description as type_renewal', 'brightnesses.description as brightness', 'type_sombers.description as type_somber', 'strokes.description as stroke')
                                            ->join('varietie_coffees', 'varietie_coffees.id' , '=' , 'lots.varietie_coffee_id')
                                            ->join('renewals', 'renewals.id' , '=' , 'lots.renewal_id')
                                            ->join('type_renewals', 'type_renewals.id' , '=' , 'lots.type_renewal_id')
                                            ->join('brightnesses', 'brightnesses.id' , '=' , 'lots.brightness_id')
                                            ->join('type_sombers', 'type_sombers.id' , '=' , 'lots.type_somber_id')
                                            ->join('strokes', 'strokes.id' , '=' , 'lots.stroke_id')
                                            ->where('lots.id',$id_lot)
                                            ->first());
    } else {
        return $this->errorResponse(null, 'Lot not found', 404);
    }
  }

  public function deleteFarm($farm_id){
    \DB::beginTransaction();
        try {
            if(is_null($farm = Farm::find($farm_id))){
                return $this->errorResponse(null, 'Farm not found', 404);
            }
            $farm->state = false;
            $farm->save();
            $lots = $farm->lots()->get();
            foreach ($lots as $key => $lot) {
                $lot->state = false;
                $lot->save();
                $soils = $lot->soils()->get();
                foreach ($soils as $key => $soil) {
                    $soil->state = false;
                    $soil->save();
                }
            }
            \DB::commit();
            return $this->successResponse(null, 'Finca eliminada correctamente.');
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
  }

  public function deleteLot($lot_id){
    \DB::beginTransaction();
    try {
      if(is_null($lot = Lot::find($lot_id))){
        return $this->errorResponse(null, 'Lot not found', 404);
      }
      $farm = Farm::find($lot->farm_id);
      $lot->state = false;
      $lot->save();

      $farm->available_area += $lot->total_area;
      $farm->save();
      $soils = $lot->soils()->get();
      foreach ($soils as $key => $soil) {
          $soil->state = false;
          $soil->save();
      }
      \DB::commit();
      return $this->successResponse(null, 'Lote eliminado correctamente.');
    } catch (\Exception $e) {
      \DB::rollback();
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }

  public function deleteAnalysis($analysis_id){
    try {
      if(is_null($analysis = SoilAnalysis::find($analysis_id))){
        return $this->errorResponse(null, 'Soil analysis not found', 404);
      }
      $analysis->state = false;
      $analysis->save();
      \DB::commit();
      return $this->successResponse(null, 'Analisis eliminado correctamente.');
    } catch (\Exception $e) {
      \DB::rollback();
      return $this->errorResponse(null, $e->getMessage(), 422);
    }
  }
}
