<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supervisor\LineController;
use App\Http\Controllers\Supervisor\StationController;
use App\Http\Controllers\Supervisor\FGModelController;
use App\Http\Controllers\Supervisor\ComponentController;
use App\Http\Controllers\Supervisor\TracePlanController;
use App\Http\Controllers\Supervisor\ComponentTypeController;
use App\Http\Controllers\Supervisor\DashboardController;
use App\Http\Controllers\Production\ProductionRunController;
use App\Http\Controllers\Production\DashboardController as ProdDashboard;
use App\Http\Controllers\Production\StationSessionController;
use App\Http\Controllers\Production\DummyTagController;
use App\Http\Controllers\Production\StationClosureController;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

Route::middleware(['auth', 'role:leader'])
    ->prefix('production')
    ->name('production.')
    ->group(function () {
        Route::get('/', [ProdDashboard::class, 'index'])->name('dashboard');

        // Corridas
        Route::post('/runs', [ProductionRunController::class, 'store'])->name('runs.store');
        Route::get('/runs/{productionRun}', [ProductionRunController::class, 'show'])->name('runs.show');
        Route::post('/runs/{productionRun}/end', [ProductionRunController::class, 'end'])->name('runs.end');

        // Estaciones
        Route::get('/runs/{productionRun}/station', [StationSessionController::class, 'create'])->name('stations.session');
        Route::post('/runs/{productionRun}/station', [StationSessionController::class, 'store'])->name('stations.store');

        // Escaneo
        Route::get('/stations/{stationSession}/scan', [DummyTagController::class, 'scan'])->name('stations.scan');
        Route::post('/stations/{stationSession}/scan', [DummyTagController::class, 'process'])->name('dummy.scan.process');

        // Resumen y cierre
        Route::get('/stations/{stationSession}/summary', [StationClosureController::class, 'summary'])->name('stations.summary');
        Route::post('/stations/{stationSession}/close', [StationClosureController::class, 'close'])->name('stations.close');
    });
