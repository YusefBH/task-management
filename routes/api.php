<?php

use App\Http\Controllers\Invitation\AcceptInvitationController;
use App\Http\Controllers\Invitation\CreateInvitationController;
use App\Http\Controllers\Project\CreateProjectController;
use App\Http\Controllers\Project\DeleteProjectController;
use App\Http\Controllers\Project\IndexProjectController;
use App\Http\Controllers\Project\ShowProjectController;
use App\Http\Controllers\Project\UpdateProjectController;
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

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('projects')->name('project.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', IndexProjectController::class)->name('index');
    Route::post('/', CreateProjectController::class)->name('create');
    Route::get('/{project}', ShowProjectController::class)->name('show');
    Route::put('/{project}', UpdateProjectController::class)->name('update');
    Route::delete('/{project}', DeleteProjectController::class)->name('delete');
});


Route::prefix('projects/{project}/invitation')->name('invitation.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    //Route::get('/', IndexInvitationController::class)->name('index');
    Route::post('/', CreateInvitationController::class)->name('create');
    Route::get('/{hash}', AcceptInvitationController::class)->name('user.to.project');
    //Route::get('/{project}', ShowInvitationController::class)->name('show');
});

