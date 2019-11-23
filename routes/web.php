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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::resource('years','YearController');
Route::resource('courses','CourseController');
Route::resource('semesters','SemesterController');
Route::resource('streams','StreamController');
Route::resource('users','UserController');
Route::resource('students','StudentController');
Route::resource('marksheets','MarksheetController');
// Route::post('students', 'StudentController@search');
Route::post('/streamlist', 'StreamController@list')->name('streams.list');
