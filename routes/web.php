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

Route::redirect('/', 'login');



Route::middleware(['auth'])->group(function(){

    //get Projects 
    Route::get("/projects" , 'App\Http\Controllers\ProjectController@get_projects')->name('projects.all') ;
    // get Single Project
    Route::get("/projects/show/{project_id}",'App\Http\Controllers\ProjectController@get_single_project')->name('projects.single'); 


    // Create Task View
    Route::get("/task/create" , 'App\Http\Controllers\TaskController@create')->name("task.create");
    Route::post("/task/store" ,  'App\Http\Controllers\TaskController@store' )->name("task.store");

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});






require __DIR__.'/auth.php';
