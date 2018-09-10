<?php
use Illuminate\Support\Facades\Auth;
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
Auth::routes();


Route::get('/', 'SearchController@index')->name('search.index');
Route::middleware('auth')->group(function() {
    Route::get('/upload', 'AdminController@upload')->name('admin.upload');
    Route::post('/upload', 'AdminController@store')->name('admin.store');
    Route::get('/display', 'AdminController@index')->name('admin.index');
    Route::delete('/image/{id}', 'AdminController@destroy')->name('admin.delete');
    Route::get('/home', 'HomeController@index')->name('home');

});
Route::get('/search/query', 'SearchController@store')->name('search.store');

