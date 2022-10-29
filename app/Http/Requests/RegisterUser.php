<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Factory;

class RegisterUser extends FormRequest
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
            //'document_type' => 'required',
            'document_type_id' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'number' => 'required|unique:user_details',
            'celphone' => 'required',
            'therms_and_conditions' => 'required',
            'name' => 'required',
            //'last_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            //'document_type.required' => 'El campo tipo de documento es obligatorio.',
            'document_type_id.required' => 'El campo id tipo de documento es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya se encuentra registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'number.required' => 'El campo número de documento es obligatorio.',
            'number.unique' => 'El número de documento ya se encuentra registrado.',
            'celphone.required' => 'El campo celular es obligatorio.',
            'therms_and_conditions.required' => 'El campo terminos y condiciones es obligatorio.',
            'name.required' => 'El campo nombres es obligatorio.',
            //'last_name.required' => 'El campo apellidos es obligatorio.'
            // Here we let Laravel to fill the placeholder with the name of the attribute
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => $validator->errors(), 'data' => null, 'code' => 422 ,'status' => 'failed'], 422));
    }
}
