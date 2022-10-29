<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\DocumentType;
use App\Models\Holding;
use App\Models\VarietieCoffee;
use App\Models\Renewal;
use App\Models\TypeRenewal;
use App\Models\Brightness;
use App\Models\TypeSomber;
use App\Models\Stroke;
use App\Models\ProductType;
use App\Models\UnitMeasurement;

class UtilitiesController extends ApiController
{
    //
    public function documentTypes()
    {
        try {
            return $this->successResponse(DocumentType::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function holdings()
    {
        try {
            return $this->successResponse(Holding::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function varietiesCoffee()
    {
        try {
            return $this->successResponse(VarietieCoffee::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function renewals()
    {
        try {
            return $this->successResponse(Renewal::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function typeRenewals()
    {
        try {
            return $this->successResponse(typeRenewal::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function brightnesses()
    {
        try {
            return $this->successResponse(Brightness::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function typeSombers()
    {
        try {
            return $this->successResponse(TypeSomber::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function strokes()
    {
        try {
            return $this->successResponse(Stroke::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function productTypes(){
        try {
            return $this->successResponse(ProductType::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function unitMeasurements(){
        try {
            return $this->successResponse(UnitMeasurement::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }
}
