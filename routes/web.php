<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supervisor\LineController;
use App\Http\Controllers\Supervisor\StationController;
use App\Http\Controllers\Supervisor\FGModelController;
use App\Http\Controllers\Supervisor\ComponentController;
use App\Http\Controllers\Supervisor\TracePlanController;

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

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::resource('lines', LineController::class);
    Route::resource('stations', StationController::class);
    Route::resource('fg-models', FGModelController::class);
    Route::resource('components', ComponentController::class);
    Route::resource('trace-plans', TracePlanController::class);
});

