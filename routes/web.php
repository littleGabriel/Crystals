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
Route::any('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::any('/home/dir/{dir}', 'HomeController@dir')->name('dir')->middleware('verified');
Route::post('/home/upload', 'HomeController@upload')->name('upload')->middleware('verified');
Route::post('/home/delete', 'HomeController@delete')->name('delete')->middleware('verified');
Route::post('/home/rename', 'HomeController@rename')->name('rename')->middleware('verified');
Route::post('/home/reDir', 'HomeController@reDir')->name('reDir')->middleware('verified');
Route::post('/home/folderPlus/{dir}', 'HomeController@folderPlus')->name('folderPlus')->middleware('verified');
Route::any('/home/share', 'HomeController@share')->name('share');

Route::get('login/github', 'Auth\AuthController@redirectToProvider');
Route::get('login/github/callback', 'Auth\AuthController@handleProviderCallback');



