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

Route::get('/QB/home','QBcontroller@homeView');
Route::get('/QB/create','QBcontroller@createQBView');
Route::get('/QB/addQuestionToQB','QBcontroller@addQuestionToQBView');

<<<<<<< Updated upstream
Route::post('/createQB','QBcontroller@createQB');
Route::post('/addQuestionToQB','QBcontroller@addQuestionToQB');
=======
// Question banks routes
Route::get('/QB/home', 'QBcontroller@homeView');
Route::get('/QB/create', 'QBcontroller@createQBView');
Route::get('/QB/addQuestionToQB/{QuestionBankID}', 'QBcontroller@addQuestionToQB');
Route::post('/QB/addQuestionToQB/{QuestionBankID}' , 'QBcontroller@addQuestionToQBView');
Route::post('/QB/delete/{QuestionBankID}', 'QBcontroller@destroy');
Route::post('/createQB', 'QBcontroller@createQB');
>>>>>>> Stashed changes

Route::get('/home', 'HomeController@index')->name('home');
