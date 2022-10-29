<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'total_area' => 'required',
            'varietie_coffee_id' => 'required',
            'distance_sites' => 'required',
            'distance_furrow' => 'required',
            'stems_sites' => 'required',
            'sites_crop' => 'required',
            'farm_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'total_area.required' => 'El campo area total en héctareas es obligatorio.',
            'varietie_coffee_id.required' => 'El campo variedad de café es obligatorio.',
            'distance_sites.required' => 'El campo distancia sitios es obligatorio.',
            'distance_furrow.required' => 'El campo distancia surco es obligatorio.',
            'stems_sites.required' => 'El campo tallos por sitios es obligatorio.',
            'sites_crop.required' => 'El campo sitios por cultivo es obligatorio.',
            'farm_id.required' => 'El campo id finca es obligatorio.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
