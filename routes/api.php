<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware'=>["auth:sanctum"]], function(){
    Route::get('/auth/users', [AuthController::class, 'listUser']);
    Route::get('/auth/persona', [PersonaController::class, 'mostrardatos']);
    Route::delete('/auth/persona/{id}',[PersonaController::class, 'eliminar']);
    Route::put('/auth/persona/{id}',[PersonaController::class, 'actualizar']);
});
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);