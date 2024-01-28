<?php

use App\Http\Controllers\Invitation\AcceptInvitationController;
use App\Http\Controllers\Invitation\CreateInvitationController;
use App\Http\Controllers\Invitation\IndexInvitationController;
use App\Http\Controllers\Label\CreateLabelController;
use App\Http\Controllers\Label\DeleteLabelController;
use App\Http\Controllers\Label\IndexLabelController;
use App\Http\Controllers\Label\ShowLabelController;
use App\Http\Controllers\Label\UpdateLabelController;
use App\Http\Controllers\Project\CreateProjectController;
use App\Http\Controllers\Project\DeleteProjectController;
use App\Http\Controllers\Project\IndexProjectController;
use App\Http\Controllers\Project\ShowProjectController;
use App\Http\Controllers\Project\UpdateProjectController;
use App\Http\Controllers\ProjectUser\DeleteProjectUserController;
use App\Http\Controllers\ProjectUser\IndexProjectUserController;
use App\Http\Controllers\ProjectUser\ShowProjectUserController;
use App\Http\Controllers\ProjectUser\UpdateProjectUserController;
use App\Http\Controllers\Subtask\CreateSubtaskController;
use App\Http\Controllers\Subtask\IndexSubtaskController;
use App\Http\Controllers\Subtask\ShowSubtaskController;
use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\IndexTaskController;
use App\Http\Controllers\Task\RemoveLabelTaskController;
use App\Http\Controllers\Task\ShowTaskController;
use App\Http\Controllers\Task\UpdateTaskController;
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

Route::get('/', function (Request $request) {
    $time = \Carbon\Carbon::now()->timestamp;
    dd($time);
});

Route::prefix('projects')->name('project.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', IndexProjectController::class)->name('index');
    Route::post('/', CreateProjectController::class)->name('create');
    Route::get('/{project}', ShowProjectController::class)->name('show');
    Route::put('/{project}', UpdateProjectController::class)->name('update');
    Route::delete('/{project}', DeleteProjectController::class)->name('delete');

    Route::prefix('/{project}/users')->name('user.')->group(function () {
        Route::get('/', IndexProjectUserController::class)->name('index');
        Route::get('/{user}', ShowProjectUserController::class)->name('show');
        Route::put('/{user}', UpdateProjectUserController::class)->name('update');
        Route::delete('/{user}', DeleteProjectUserController::class)->name('delete');
    });

    Route::prefix('/{project}/tasks')->name('task.')->group(function () {
        Route::get('/', IndexTaskController::class)->name('index');
        Route::post('/', CreateTaskController::class)->name('create');
        Route::get('/{task}', ShowTaskController::class)->name('show');
        Route::put('/{task}', UpdateTaskController::class)->name('update');
        Route::delete('/{task}', DeleteTaskController::class)->name('delete');
        Route::delete('/{task}/remove_label', RemoveLabelTaskController::class)->name('remove.label');

        Route::prefix('/{task}/subtasks')->name('subtask.')->group(function () {
            Route::get('/', IndexSubtaskController::class)->name('index');
            Route::post('/', CreateSubtaskController::class)->name('create');
            Route::get('/{subtask}', ShowSubtaskController::class)->name('show');
//            Route::put('/{subtask}', UpdateSubtaskController::class)->name('update');
//            Route::delete('/{subtask}', DeleteSubtaskController::class)->name('delete');
        });
    });

    Route::prefix('/{project}/labels')->name('label.')->group(function () {
        Route::get('/', IndexLabelController::class)->name('index');
        Route::post('/', CreateLabelController::class)->name('create');
        Route::get('/{label}', ShowLabelController::class)->name('show');
        Route::put('/{label}', UpdateLabelController::class)->name('update');
        Route::delete('/{label}', DeleteLabelController::class)->name('delete');
    });
});


Route::prefix('projects/{project}/invitation')->name('invitation.')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', IndexInvitationController::class)->name('index');
    Route::post('/', CreateInvitationController::class)->name('create');
    Route::get('/{invitation}/{hash}', AcceptInvitationController::class)->name('user.to.project');
});



