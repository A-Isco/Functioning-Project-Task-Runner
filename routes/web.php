<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// get Projects 
Route::get("/projects" , 'App\Http\Controllers\ProjectController@get_projects')->name('projects.all') ;
// get Single Project
Route::get("/projects/show/{project_id}",'App\Http\Controllers\ProjectController@get_single_project')->name('projects.single'); 


// Create Task 
Route::get("/task/create" , 'App\Http\Controllers\TaskController@create')->name("task.create");
Route::post("/task/store" ,  'App\Http\Controllers\TaskController@store' )->name("task.store");
