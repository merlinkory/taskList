<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;
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

//Route::resource('tasks', TaskController::class)->except([
//    'index'
//]);

Route::get('tasks/{subdays}', [TaskController::class, 'index'])->middleware('auth');
Route::post('tasks',[TaskController::class, 'store']);
Route::post('tasks/{id}',[TaskController::class, 'update']);
Route::delete('tasks/{id}',[TaskController::class, 'destroy']);

Route::resource('staff', StaffController::class);

Route::name('user.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class,'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
    Route::get('/logout', [\App\Http\Controllers\LoginController::class,'logout']);

    Route::view('/taskmanager', 'taskmanager')->middleware('auth')->name('taskmanager');
    Route::view('/taskmanager/create', 'taskmanager')->middleware('auth')->name('taskmanager');
    Route::view('/taskmanager/list', 'taskmanager')->middleware('auth')->name('taskmanager');
});
