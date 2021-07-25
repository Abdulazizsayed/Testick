<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/users/editProfile', 'ProfileController@edit');
    Route::post('/users/editProfile', 'ProfileController@update');
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    // Question banks routes
    Route::resource('questionsbank', 'QBcontroller');
    Route::get('/QB/index', 'QBcontroller@index');
    Route::get('/QB/create', 'QBcontroller@QBcreateView');
    Route::post('/QB/create', 'QBcontroller@QBcreate');
    Route::get('/QB/addQuestion/{QuestionBankID}', 'QBcontroller@addQuestionView');
    Route::post('/QB/addQuestion/{QuestionBankID}', 'QBcontroller@addQuestion');
    Route::post('/QB/delete/{QuestionBankID}', 'QBcontroller@destroy');
    Route::post('QB/search', 'QBcontroller@search');
    Route::post('QB/chapters/{questionBankId}', 'QBcontroller@chapters');
    Route::post('QB/questions/{questionBankId}', 'QBcontroller@getQuestions');

    // Course routes
    Route::resource('course', 'courseController');
    Route::get('/course/teacher/index', 'courseController@index');
    Route::get('/course/teacher/announcementLog', 'courseController@announcementLogView');
    Route::get('/course/teacher/memberList/{courseID}', 'courseController@memberlistView');
    Route::post('/course/teacher/createAnnouncement', 'courseController@createAnnouncement');
    Route::post('/course/search', 'courseController@search');

    // Exam routes
    Route::resource('exams', 'ExamController');
    Route::post('exams/search', 'ExamController@search');
    Route::post('exams/grades/search', 'ExamController@gradesSearch');
    Route::post('exams/deleteQuestion/{questionId}/{examId}', 'ExamController@deleteQuestion');
    Route::get('exams/addQuestion/{exam}', 'ExamController@addQuestionView');
    Route::post('exams/addQuestion/{exam}', 'ExamController@addQuestion');
    Route::get('exams/analysis/{exam}', 'ExamController@analysis');
    Route::post('exams/questionAnalysis', 'ExamController@questionAnalysis');
    Route::post('exams/chapterAnalysis', 'ExamController@chapterAnalysis');
    Route::get('exams/studentsGrades/{exam}', 'ExamController@studentsGradesView');
    Route::get('exams/create/{isRandomlly}', 'ExamController@createExamView');
    Route::post('exams/create/manually', 'ExamController@createExamManually');
    Route::post('exams/create/randomlly', 'ExamController@createExamRandomlly');
    Route::get('exams/answers/{examId}/{studentId}', 'ExamController@studentAnswers');

    // Question routes
    Route::put('questions/updateExamQuestion/{question}', 'Questioncontroller@updateExamQuestion');
    Route::post('questions/{question}', 'Questioncontroller@destroy');
    Route::post('questions/search/{filterBy}/{searchValue}/{questionBankId}', 'Questioncontroller@search');

    // Answer routes
    Route::put('answers/updateQuestionAnswer/{answer}', 'AnswerController@updateQuestionAnswer');
    Route::post('answers/{answer}', 'AnswerController@destroy');
});

Route::middleware(['auth', 'student'])->group(function () {
    // Course routes
    Route::get('/course/student/index', 'courseController@studentindex')->name('course.student.index');
    Route::get('/course/student/courseView/{couresID}', 'courseController@studentCourseView');

    // Exam routes
    Route::get('exams/student/index', 'ExamController@studentIndexView')->name('exams.student.index');
    Route::get('exams/student/enterExam/{examId}', 'ExamController@enterExam');
    Route::post('exams/student/markExam/{examId}', 'ExamController@markExam');
    Route::get('exams/student/answers/{examId}', 'ExamController@myAnswers');
});

// Error routes
Route::get('errorPages/accessDenied', 'ErrorController@accessDenied');
