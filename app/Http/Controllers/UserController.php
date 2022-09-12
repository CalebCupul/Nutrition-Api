<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $response = ['status_code' => 404, 'data' => ['status' => 'error', 'user' => null, 'token' => null]];

        try {
            $fields = $request->validated();

            $fields['password'] = bcrypt($fields['password']);
            $user = User::create($fields);
            $user->assignRole('user');
            $response['data'] = ['status' => 'success', 'user' => $fields, 'message' => 'Usuario creado con éxito.'];
            $response['status_code'] = 200;
        } catch (\Exception $e) {

            $response['status_code'] = 400;
        }

        return response()->json($response);
    }

    public function destroy(User $user)
    {
        $response = ['status_code' => 404, 'data' => ['status' => 'error']];

        try {

            if($user->hasRole('superAdmin')){
                $response['data'] = ['message' => 'No tienes permiso de borrar este usuario.'];
                $response['status_code'] = 403;

                return response()->json($response);
            }

            if($user->hasRole('admin')){
                $adminCount = User::role('admin')->count();

                if($adminCount == 1){
                    $response['data'] = ['message' => 'Crea otro usuario administrador antes de borrar el último administrador!'];
                    $response['status_code'] = 403;
                    return response()->json($response);
                }
            }

            $user->delete();
            $response['data'] = ['status' => 'success', 'message' => 'Usuario borrado con éxito.'];
            $response['status_code'] = 200;

        } catch (\Exception $e) {
            $response['status_code'] = 400;
        }

        return response()->json($response);
    }
}
