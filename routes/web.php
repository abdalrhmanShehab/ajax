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
Route::get('/index',[\App\Http\Controllers\TeacherController::class,'index']);
Route::get('/teacher/all',[\App\Http\Controllers\TeacherController::class,'allData']);
Route::post('/teacher/store',[\App\Http\Controllers\TeacherController::class,'addData']);
Route::get('/teacher/edit/{id}',[\App\Http\Controllers\TeacherController::class,'editData']);
Route::post('/teacher/update/{id}',[\App\Http\Controllers\TeacherController::class,'updateData']);
Route::get('/teacher/delete/{id}',[\App\Http\Controllers\TeacherController::class,'deleteData']);
