<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| patch (Actualizaciones parciaciales a un recurso, aplica solo a una columna)
|
*/

// Rutas públicas de autenticación
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/about', [AuthController::class, 'about']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('shipments', App\Http\Controllers\Api\ShipmentController::class);
    Route::patch('/shipments/{id}/activate', [App\Http\Controllers\Api\ShipmentController::class, 'activate']);
    Route::patch('/shipments/{id}/desactivate', [App\Http\Controllers\Api\ShipmentController::class, 'desactivate']);
    Route::get('/thirds', [App\Http\Controllers\Api\ThirdController::class, 'index']);
    Route::get('/merchandises', [App\Http\Controllers\Api\MerchandiseController::class, 'index']);

});
