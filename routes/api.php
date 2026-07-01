<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// Endpoint Activar Servidor
Route::get('/ping', function () {
    return response()->json(['status' => 'online', 'message' => 'Servidor Activo']);
});

Route::prefix('v1')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/reportes/generar', [ReportController::class, 'generate']);

});