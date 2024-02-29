<?php

use App\Http\Controllers\LabyrinthController;
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

Route::prefix('v1/labyrinth')->middleware('auth.basic')->group(function () {
    Route::controller(LabyrinthController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{labyrinth}', 'show');
        Route::put('/{labyrinth}/playfield/{x}/{y}/{type}', 'updatePlayfield');
        Route::put('/{labyrinth}/start/{x}/{y}', 'setStart');
        Route::put('/{labyrinth}/end/{x}/{y}', 'setEnd');
        Route::get('/{labyrinth}/solution', 'solution');
    });
});
