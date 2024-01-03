<?php

use App\Http\Controllers\Project\CreateProjectController;
use App\Http\Controllers\Project\IndexProjectController;
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

Route::prefix('projects')->middleware(['auth:sanctum' /*, 'verified'*/])->group(function () {//todo : verify check
    Route::get('/', IndexProjectController::class);
    Route::post('/', CreateProjectController::class);
/*    Route::post('/{project}',  ShowProjectController::class);
    Route::put('/{project}',  UpdateProjectController::class);
    Route::delete('/{project}',  DeleteProjectController::class);*/
});

require __DIR__.'/auth.php';
