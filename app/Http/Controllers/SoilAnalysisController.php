<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SoilAnalysisRequest;
use App\Models\SoilAnalysis;
use App\Models\Lot;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class SoilAnalysisController extends ApiController
{
    
    public function create(SoilAnalysisRequest $request)
    {
        try {
            \DB::beginTransaction();
            if(!is_null($lot = Lot::where('state', true)->find($request->lot_id))){
                $analysis = SoilAnalysis::create($request->all());
                \Log::info('Success analysis create: ' . $analysis->analysis_date . ' with id: '. $analysis->id);
                \DB::commit();
                return $this->successResponse($analysis, 'Análisis de suelo creado correctamente', 201);
            } else {
                return $this->errorResponse(null, 'Lot not found', 404);
            }
        } catch (\Exception $e) {
            \Log::critical('Error analysis create: ' . $request->analysis_date);
            \DB::rollback();
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function details($id_analysis){
        try {
            if(!is_null($analysis = SoilAnalysis::where('state', true)->find($id_analysis))){
                return $this->successResponse($analysis);
            } else {
                return $this->errorResponse(null, 'Analysis not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function update(SoilAnalysisRequest $request, $id_analysis)
    {
        try {
            if(!is_null($analysis = SoilAnalysis::where('state', true)->find($id_analysis))){
                $analysis->update($request->all());
                return $this->successResponse($analysis);
            } else {
                return $this->errorResponse(null, 'Analysis not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function indexAnalysis($id_lot)
    {
        try {
            $data = DB::table('soil_analyses as sa')->select('*')->where('sa.lot_id',$id_lot)->where('state', true)->get();
            if($data){
                return  $this->successResponse( $data );
            } else {
                return $this->errorResponse([], 'Farm not found', 404);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }
}
