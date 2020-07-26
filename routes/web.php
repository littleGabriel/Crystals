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
Route::any('/admin/login', 'Admin\loginController@login');
Route::any('/admin/index', function () {
    return view('admin.index');
});

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('login/github', 'Auth\AuthController@redirectToProvider');
Route::get('login/github/callback', 'Auth\AuthController@handleProviderCallback');



