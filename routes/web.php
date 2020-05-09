<?php

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
    return view('index');
});

Auth::routes();

Route::post("/tasks","TaskController@store")->name("task.store");
Route::get("/tasks","TaskController@index")->name("task.index");
Route::delete("/task/{id}/delete","TaskController@destroy")->name("task.delete");
Route::patch("/task/{id}/update","TaskController@update")->name("task.update");