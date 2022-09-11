<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function create(StoreUserRequest $request)
    {
        $response = ['status_code' => 404, 'data' => ['status' => 'error', 'user' => null, 'token' => null]];

        try {
            $fields = $request->validated();

            $fields['password'] = bcrypt($fields['password']);
            $user = User::create($fields);
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response['data'] = ['status' => 'success', 'user' => $fields, 'token' => $token];
            $response['status_code'] = 200;
        } catch (\Exception $e) {

            $response['status_code'] = 400;
        }

        return response()->json($response);
    }
}
