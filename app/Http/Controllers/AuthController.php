<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $response = ['status_code' => 404, 'data' => ['status' => 'error', 'message' => 'Ocurrió un error.']];

        try {
            $fields = $request->validated();
            $user = User::where('email', $fields['email'])->first();

            if ( !$user || !Hash::check($fields['password'], $user->password )){
                $response = ['status_code' => 401, 'data' => ['message' => 'Credenciales incorrectas, intente denuevo.']];
                return response()->json($response);
            }

            if ($user->hasRole('superAdmin')){
                $token = $user->createToken('authToken', ['superAdmin'])->plainTextToken;
            }else if($user->hasRole('admin')){
                $token = $user->createToken('authToken', ['admin'])->plainTextToken;
            }else if($user->hasRole('user')){
                $token = $user->createToken('authToken', ['user'])->plainTextToken;
            }

            $response['data'] = ['status' => 'success', 'user' => $user, 'token' => $token, 'message' => 'Bienvenido!'];
            $response['status_code'] = 200;
        } catch (\Exception $e) {

            $response['status_code'] = 400;
        }

        return response()->json($response);
    }

    public function logout(Request $request){

        Log::debug($request);
        $response = ['status_code' => 404, 'data' => ['status' => 'error', 'message' => 'Ocurrió un error.']];

        try {
            $request->user()->tokens()->delete();
            $response['data'] = ['status' => 'success', 'message' => 'Desconectado'];
            $response['status_code'] = 200;
        } catch (\Exception $e) {

            $response['status_code'] = 400;
        }

        return response()->json($response);
    }
   
}
