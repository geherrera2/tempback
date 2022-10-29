<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FarmRequest extends FormRequest
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
            'department_id' => 'required',
            'municipality_id' => 'required',
            'village_id' => 'required',
            'name' => 'required',
            'holding_id' => 'required',
            'total_area' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => 'El campo departamento es obligatorio.',
            'municipality_id.required' => 'El campo municipio es obligatorio.',
            'village_id.required' => 'El campo vereda es obligatorio.',
            'name.required' => 'El campo nombre finca es obligatorio.',
            'total_area.required' => 'El campo área total en hectareas es obligatorio.',
            'holding_id.required' => 'El campo tenencia es obligatorio.'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
