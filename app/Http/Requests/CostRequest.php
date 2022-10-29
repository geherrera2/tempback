<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CostRequest extends FormRequest
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
            'type_cost_id',
            'farm_id',
            'stage_id',
            'amount',
            'unit_cost'
        ];
    }

    public function messages()
    {
        return [
            'type_cost_id.required' => 'El campo tipo de costo es obligatorio.',
            'farm_id.required' => 'El campo finca es obligatorio.',
            'stage_id.required' => 'El campo etapa es obligatorio.',
            'amount.required' => 'El campo cantidad es obligatorio.',
            'unit_cost.required' => 'El campo costo unitario es obligatorio.'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
