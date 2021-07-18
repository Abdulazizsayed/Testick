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

// Question banks routes
Route::resource('questionsbank', 'QBcontroller');
Route::get('/QB/index', 'QBcontroller@index');
Route::get('/QB/create', 'QBcontroller@QBcreateView');
Route::post('/QB/create', 'QBcontroller@QBcreate');
Route::get('/QB/addQuestion/{QuestionBankID}', 'QBcontroller@addQuestionView');
Route::post('/QB/addQuestion/{QuestionBankID}', 'QBcontroller@addQuestion');
Route::post('/QB/delete/{QuestionBankID}', 'QBcontroller@destroy');
Route::post('QB/search', 'QBcontroller@search');

// Course routes
Route::resource('course', 'courseController');
Route::post('/course/announcementLog', 'courseController@announcementLog');
Route::post('/course/createAnnouncement', 'courseController@createAnnouncement');



// User routes
Route::get('/users/editProfile', 'ProfileController@edit');
Route::post('/users/editProfile', 'ProfileController@update');

// Exam routes
Route::resource('exams', 'ExamController');
Route::post('exams/search', 'ExamController@search');
Route::post('exams/grades/search', 'ExamController@gradesSearch');
Route::get('exams/addQuestion/{exam}', 'ExamController@addQuestionView');
Route::post('exams/addQuestion/{exam}', 'ExamController@addQuestion');
Route::get('exams/analysis/{exam}', 'ExamController@analysis');
Route::get('exams/create/{isManually}', 'ExamController@createExamView');
Route::post('exams/questionAnalysis', 'ExamController@questionAnalysis');
Route::post('exams/chapterAnalysis', 'ExamController@chapterAnalysis');
Route::get('exams/studentsGrades/{exam}', 'ExamController@studentsGradesView');

// Question routes
Route::put('questions/updateExamQuestion/{question}', 'Questioncontroller@updateExamQuestion');

// Answer routes
Route::put('answers/updateQuestionAnswer/{answer}', 'AnswerController@updateQuestionAnswer');

// Error routes
Route::get('errorPages/accessDenied', 'ErrorController@accessDenied');
