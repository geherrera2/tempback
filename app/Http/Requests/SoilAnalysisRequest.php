<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class SoilAnalysisRequest extends FormRequest
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
            'analysis_date' => 'required',
            'lot_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'analysis_date.required' => 'El campo fecha de análisis es obligatorio.',
            'lot_id.required' => 'El campo  id de lote es obligatorio.'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
