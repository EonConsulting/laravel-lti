<?php

Route::group(['middleware' => ['web'], 'prefix' => '/eon/lti', 'namespace' => 'EONConsulting\LaravelLTI\Http\Controllers'], function() {
    Route::group(['middleware' => ['auth']], function() {

        Route::get('/launch', ['as' => 'eon.laravellti.launch', 'uses' => 'LaunchLTIToolController@launch']);

        // list all of the api's
        Route::get('/install', ['as' => 'eon.laravellti.install', 'uses' => 'InstallLTIToolController@index']);
        Route::post('/install', ['as' => 'eon.laravellti.install', 'uses' => 'InstallLTIToolController@store']);
        Route::get('/delete/{lticontext}', ['as' => 'eon.laravellti.delete', 'uses' => 'DeleteLTIToolController@show']);
        Route::post('/delete/{lticontext}', ['as' => 'eon.laravellti.delete', 'uses' => 'DeleteLTIToolController@destroy']);

        Route::get('/categories', ['as' => 'eon.laravellti.cats', 'uses' => 'ToolCatsController@index']);
        Route::get('/categories/create', ['as' => 'eon.laravellti.cats.create', 'uses' => 'CreateCatController@create']);
        Route::post('/categories/create', ['as' => 'eon.laravellti.cats.create', 'uses' => 'CreateCatController@store']);
        Route::post('/categories/delete/{id}', ['as' => 'eon.laravellti.cats.delete', 'uses' => 'CreateCatController@destroy']);
    });
});

