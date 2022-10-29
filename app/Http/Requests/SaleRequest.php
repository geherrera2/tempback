<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaleRequest extends FormRequest
{
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
            'farm_id' => 'required',
            'lot_id'=> 'required',
            'date'=> 'required',
            'amount_loads'=> 'required',
            'sale_value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'farm_id.request' => 'El campo finca es obligatorio',
            'lot_id.request' => 'El campo lote es obligatorio',
            'date.request' => 'El campo fecha es obligatorio',
            'amount_loads.request' => 'El campo cantidad de cargas es obligatorio',
            'sale_value.request' => 'El campo valor de venta es obligatorio',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
