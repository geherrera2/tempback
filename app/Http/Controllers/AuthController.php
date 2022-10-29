<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeToCultibot;
use App\Mail\ForgotPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetail;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{    
    public function testpermisos(){
        $user = Auth::user();
        // $permissionNames = $user->getPermissionNames(); 
        return response()->json($user, 200);
    }

    public function getUser(){
        
    }

    public function register(RegisterUser $request)
    {
        try {
            \DB::beginTransaction();
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            \Log::info('Success user create: ' . $user->email);

            $user_details = $user->details()->create([                
                'document_type_id' => $request->document_type_id,
                'number' => $request->number,
                'celphone' => $request->celphone,
                'therms_and_conditions' => $request->therms_and_conditions,
                'name' => $request->name,
                'last_name' => $request->last_name
            ]);
            \Log::info('Success user details create: ' . $user_details->id);
            Mail::to($request->email)->send(new WelcomeToCultibot());
            \DB::commit();            
            return $this->successResponse(null, 'Usuario creado correctamente', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 422);
        }
    }

    public function forgot (ForgotRequest $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return $this->errorResponse(null, 'El usuario no existe', 404);
        }

        $token = Str::random(10);

        try {
            \DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            
            $route = config('app.url') . '/forgot?token=' . $token;
            Mail::to($email)->send(new ForgotPassword($route));

            return $this->successResponse(['route' => $route], 'Verifica tu correo', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 400);
        }
    }

    public function indexForgot(Request $request){
        $token = $request->token;
        return view('users.forgot', compact('token'));
    }

    public function reset(ResetRequest $request){
        $token = $request->token;

        if(!$password_resets = \DB::table('password_resets')->where('token', $token)->first()){
            $this->errorResponse(null, 'Token invalido', 400);
        }

        if( !$user = User::where('email', $password_resets->email)->first()){
            return $this->errorResponse(null, 'El usuario no existe', 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return view('users.confirmforgot', compact('token'));
        // return $this->successResponse(null, 'Se ha creado correctamente la contrasena', 200);
    }
}
