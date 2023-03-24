<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NubeController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\TipoArchivoController;
use App\Http\Controllers\TamañoController;
use App\Http\Controllers\FechaIngresoController;

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

Route::resource('archivos', ArchivoController::class);
Route::resource('nubes', NubeController::class);
Route::resource('tipo_archivos', TipoArchivoController::class);
Route::resource('tamaños', TamañoController::class);
Route::resource('fecha_ingresos', FechaIngresoController::class);

