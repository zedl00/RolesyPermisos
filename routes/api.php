<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/auth')->group(function(){
    Route::post("/login", [AuthController::class, "funIngresar"]);
    Route::post("/register", [AuthController::class, "funRegistro"]);

    Route::middleware('auth:sanctum')->group(function(){
    
        Route::get("/perfil",  [AuthController::class, "funPerfil"]);
        Route::post("/logout", [AuthController::class, "funSalir"]);
    });
});                  

