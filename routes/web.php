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

Auth::routes(['register' => false]);
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

// User routes
Route::get('/users/editProfile', 'ProfileController@edit');
Route::post('/users/editProfile', 'ProfileController@update');

// Question banks routes
Route::get('/QB/home', 'QBcontroller@homeView');
Route::get('/QB/create', 'QBcontroller@createQBView');
Route::get('/QB/addQuestionToQB', 'QBcontroller@addQuestionToQBView');
Route::post('/QB/delete/{QuestionBankID}', 'QBcontroller@destroy');
Route::post('/createQB', 'QBcontroller@createQB');
Route::post('/addQuestionToQB', 'QBcontroller@addQuestionToQB');

// Exam routes
Route::resource('exams', 'ExamController');
Route::post('exams/search', 'ExamController@search');

// Error routes
Route::get('errorPages/accessDenied', 'ErrorController@accessDenied');
