<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['validate.headers']], function () {

  Route::get('token', 'AuthController@getDefaultJWT');

  Route::group(['prefix' => 'courses'], function () {
    Route::get('/', 'CoursesController@paginated');
    Route::get('/all', 'CoursesController@all');
    Route::get('/{id}', 'CoursesController@show')->where('id','\d+');
    Route::post('/', 'CoursesController@store');
    Route::put('/{id}', 'CoursesController@update')->where('id','\d+');
    Route::delete('/{id}', 'CoursesController@destroy')->where('id','\d+');
  });

  Route::group(['prefix' => 'students'], function () {
    Route::get('/', 'StudentsController@paginated');
    Route::get('/all', 'StudentsController@all');
    Route::get('/{id}', 'StudentsController@show')->where('id','\d+');
    Route::post('/', 'StudentsController@store');
    Route::put('/{id}', 'StudentsController@update')->where('id','\d+');
    Route::delete('/{id}', 'StudentsController@destroy')->where('id','\d+');
  });

});
