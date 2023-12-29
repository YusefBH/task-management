<?php

use App\Http\Controllers\User\IndexUserController;
use App\Http\Controllers\User\ShowUserController;
use App\Http\Controllers\User\UpdateUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//IndexUserController
//UpdateUserController
//ShowUserController

Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', IndexUserController::class );
    Route::put('/{user}', UpdateUserController::class );
    Route::get('/{user}', ShowUserController::class );
});


require __DIR__.'/auth.php';
