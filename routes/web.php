<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NubeController;
use App\Http\Controllers\TipoArchivoController;
use App\Http\Controllers\TamañoController;
use App\Http\Controllers\FechaIngresoController;
use App\Http\Controllers\PlanAlmacenamientoController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('Archivo', ArchivoController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [HomeController::class, 'dash'])->name('admin.dash')->middleware('auth.admin');
Route::resource('users', User::class);
Route::resource('nubes', NubeController::class)->middleware('auth.admin');
Route::resource('archivos', ArchivoController::class)->middleware('auth.admin');
Route::resource('tipo_archivos', TipoArchivoController::class)->middleware('auth.admin');
Route::resource('tamaños', TamañoController::class)->middleware('auth.admin');
Route::resource('fecha_ingresos', FechaIngresoController::class)->middleware('auth.admin');
Route::resource('plan_almacenamientos', PlanAlmacenamientoController::class);

