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

/** routes pour tasks */
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
Route::get('/task/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('task.show');
Route::get('/create/task', [App\Http\Controllers\TaskController::class, 'create'])->name('task.create');
Route::post('/create/task', [App\Http\Controllers\TaskController::class, 'store'])->name('task.store')->middleware('auth');
Route::get('/edit/task/{task}', [App\Http\Controllers\TaskController::class, 'edit'])->name('task.edit');
Route::put('/edit/task/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('task.update')->middleware('auth');
Route::delete('/task/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('task.delete')->middleware('auth');

Route::get('/completed/task/{completed}', [App\Http\Controllers\TaskController::class, 'completed'])->name('task.completed');

Route::get('/query', [App\Http\Controllers\TaskController::class, 'query']);


/** routes pour utilisateurs */
// Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/registration', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
Route::post('/registration', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
// Route::get('/edit/user/{user}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::middleware('auth')->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    // Route::get('/registration', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    // Route::post('/registration', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/edit/user/{user}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
});


/** routes pour connexion */
Route::get('/login', [App\Http\Controllers\AuthController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');