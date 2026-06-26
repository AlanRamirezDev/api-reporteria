<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/reportes/generar', [ReportController::class, 'generate']);

// Endpoint Activar Servidor
Route::get('/ping', function () {
    return response()->json(['status' => 'online', 'message' => 'Servidor Activo']);
});