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

Route::get('/tasks', 'TasksController@index');

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/about', function () {
    return view('about');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/register_alt','Auth\RegisterAltController@register');

Route::get('/tasques', 'TasquesController@index');
