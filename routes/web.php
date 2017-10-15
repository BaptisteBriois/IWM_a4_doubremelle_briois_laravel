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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/projects', 'ProjectController');

Route::get('/projects/{id}/users', 'ProjectController@getProjectUsers')->name('projects.users.index');
Route::post('/projects/{id}/addAdmin', 'ProjectController@addProjectAdmin')->name('projects.users.addAdmin');
Route::post('/projects/{id}/addViewer', 'ProjectController@addProjectViewer')->name('projects.users.addViewer');
Route::post('/projects/{id}/removeUser', 'ProjectController@removeProjectUser')->name('projects.users.removeUser');

Route::resource('/tasks', 'TaskController');

Route::post('/tasks/updateOrder', 'TaskController@updateOrder')->name('tasks.updateOrder');

Route::resource('/categories', 'CategoryController');