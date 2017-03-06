<?php

Route::group(['middleware' => ['web'], 'prefix' => '/eon/lti', 'namespace' => 'EONConsulting\LaravelLTI\Http\Controllers'], function() {
    Route::group(['middleware' => ['auth']], function() {

        // list all of the api's
        Route::get('/install', ['as' => 'eon.laravellti.install', 'uses' => 'InstallLTIToolController@index']);
        Route::post('/install', ['as' => 'eon.laravellti.install', 'uses' => 'InstallLTIToolController@store']);
        Route::get('/delete/{lticontext}', ['as' => 'eon.laravellti.delete', 'uses' => 'DeleteLTIToolController@show']);
        Route::post('/delete/{lticontext}', ['as' => 'eon.laravellti.delete', 'uses' => 'DeleteLTIToolController@destroy']);
    });
});

