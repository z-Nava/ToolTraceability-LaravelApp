<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supervisor\LineController;
use App\Http\Controllers\Supervisor\StationController;
use App\Http\Controllers\Supervisor\FGModelController;
use App\Http\Controllers\Supervisor\ComponentController;
use App\Http\Controllers\Supervisor\TracePlanController;
use App\Http\Controllers\Supervisor\ComponentTypeController;
use App\Http\Controllers\Supervisor\DashboardController;

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

Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {

        // Dashboard (vista principal del panel)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Catálogos base
        Route::resource('lines', LineController::class);
        Route::resource('stations', StationController::class);

        // Modelos y componentes
        Route::resource('fg-models', FGModelController::class);
        Route::resource('components', ComponentController::class);
        Route::resource('component-types', ComponentTypeController::class);

        // Planes de trazabilidad
        Route::resource('trace-plans', TracePlanController::class);
    });

