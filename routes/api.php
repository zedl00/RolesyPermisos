<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthPassportController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


// Sanctum 
Route::prefix('v1/auth')->group(function(){
    Route::post("/login", [AuthController::class, "funIngresar"]);
    Route::post("/register", [AuthController::class, "funRegistro"]);

    Route::middleware('auth:sanctum')->group(function(){
    
        Route::get("/perfil",  [AuthController::class, "funPerfil"]);
        Route::post("/logout", [AuthController::class, "funSalir"]);
    });
});                  


// Passport
Route::post("/passport/login", [AuthPassportController::class, "funIngresar"]);
Route::post("/passport/register", [AuthPassportController::class, "funRegistro"]);
Route::get("/passport/profile", [AuthPassportController::class, "funPerfil"])->middleware('auth:api');

// Users 
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource("users", UserController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("role", RoleController::class);
});