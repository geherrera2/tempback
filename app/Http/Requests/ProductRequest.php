<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'unit_measurement_id' => 'required',
            'product_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre de producto es obligatorio.',
            'unit_measurement_id.required' => 'El campo unidad de medida es obligatorio.',
            'product_type_id.required' => 'El campo tipo de producto es obligatorio.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
