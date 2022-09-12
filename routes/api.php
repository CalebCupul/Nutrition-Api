<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/product', function () {
        return 'productsss';
    });
    Route::post('/users/store', [UserController::class, 'store'])->middleware('ability:superAdmin');
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

});
