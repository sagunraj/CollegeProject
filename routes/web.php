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


Route::get('/', 'SearchController@index')->name('search.index');
Route::get('/upload', 'AdminController@upload')->name('admin.upload');
Route::post('/upload', 'AdminController@store')->name('admin.store');

Route::get('/search/query', 'SearchController@store')->name('search.store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
