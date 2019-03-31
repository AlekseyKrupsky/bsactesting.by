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

//dump(Route::getRoutes());

Auth::routes();

Route::middleware('auth')->get('/', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware(['auth','onlyAdmin'])->group(function () {

    Route::get('/new_users', 'Admin\UserController@new_users')->name('new_users');
    Route::patch('/new_users/{id}', 'Admin\UserController@update')->name('new_users_update');
    Route::delete('/new_users/{id}', 'Admin\UserController@delete')->name('new_users_delete');
    Route::get('/reset','Admin\UserController@reset')->name('reset_password');


    Route::get('/groups', 'Admin\GroupController@index')->name('groups');
    Route::post('/groups', 'Admin\GroupController@store');
    Route::delete('/group/{id}', 'Admin\GroupController@destroy')->name('one_group');
    Route::post('/group/{id}', 'Admin\GroupController@update')->name('one_group');

    Route::get('/teachers', 'Admin\TeacherController@index')->name('teachers');
    Route::patch('/teachers/{id}', 'Admin\TeacherController@update')->name('teacher_update');

    Route::get('/subjects', 'Admin\SubjectController@index')->name('subjects');
    Route::post('/subjects', 'Admin\SubjectController@store');
    Route::delete('/subject/{id}', 'Admin\SubjectController@destroy')->name('delete_subject');

});

Route::prefix('teacher/tests')->middleware(['auth','teachers'])->group(function () {
    Route::get('/','TestsController@index')->name('tests');
    Route::get('/edit/{id}','TestsController@edit')->name('tests_edit');
    Route::post('/edit/{id}','TestsController@update_mark_system');
    Route::post('/create','TestsController@store')->name('tests_new');
    Route::patch('/edit/{id}','TestsController@update');
    Route::delete('/{id}','TestsController@destroy')->name('test_delete');
});

Route::prefix('teacher/test/question')->middleware(['auth','teachers'])->group(function () {
    Route::delete('/{id}','QuestionController@destroy')->name('question');
    Route::get('/add/{id}', 'QuestionController@create')->name('question_add');
    Route::post('/add/{id}', 'QuestionController@store')->name('question_add');
    Route::get('/edit/{id}','QuestionController@edit')->name('question_edit');
    Route::patch('/edit/{id}','QuestionController@update')->name('question_edit');
});

Route::prefix('teacher/dashboard')->middleware(['auth','teachers'])->group(function () {
   Route::get('/','TeachersController@index')->name('teacher');
   Route::get('/show/{id}/{group_id}','TeachersController@show')->name('teacher_subject');
    Route::get('/retake/{test_id}/{user_id}','TeachersController@retake')->name('retake');
});

Route::prefix('student')->middleware('auth')->group(function () {
    Route::get('/tests','Student\TestController@index')->name('show_tests');
    Route::get('/test/{id}','Student\TestController@show')->name('show_test');
    Route::post('/test/{id}','Student\TestController@check');
});
