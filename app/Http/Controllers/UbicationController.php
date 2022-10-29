<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Municipality;
use App\Models\Village;
use App\Http\Controllers\ApiController;

class UbicationController extends ApiController
{
    public function department()
    {
        try {
            return $this->successResponse(Department::all());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function municipalities($id_department)
    {
        try {
            return $this->successResponse(Municipality::where('department_code',$id_department)->orderBy('name', 'asc')->get());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function villages($id_municipality)
    {
        try {
            return $this->successResponse(Village::where('municipalitie_code',$id_municipality)->where('center_type', 'CENTRO POBLADO')->orderBy('name', 'asc')->get());
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }
}
