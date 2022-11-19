<?php

use App\Http\Controllers\ProjectInvitationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
    Route::resource('projects', ProjectsController::class);

    Route::controller(ProjectTasksController::class)->group(function () {
        Route::post('/projects/{project}/tasks', 'store')->name('projects.tasks.store');
        Route::patch('/projects/{project}/tasks/{task}', 'update')->name('projects.tasks.update');

    });

    Route::controller(ProjectInvitationsController::class)->group(function () {
        Route::post('/projects/{project}/invitations', 'store')->name('projects.invitations.store');
    });
});
