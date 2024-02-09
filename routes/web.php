<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
Route::get('/task/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('task.show');
Route::get('/create/task', [App\Http\Controllers\TaskController::class, 'create'])->name('task.create');
Route::post('/create/task', [App\Http\Controllers\TaskController::class, 'store'])->name('task.store');
Route::get('/edit/task/{task}', [App\Http\Controllers\TaskController::class, 'edit'])->name('task.edit');
Route::put('/edit/task/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('task.update');
Route::delete('/task/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('task.delete');