<?php

/**
 * Routes index
 */
Route::get('/', 'HomeController@showRoutes');

Route::group(['prefix' => '/v1'], function () {

    /**
     * Authenticate the user via JWT
     */
    Route::post('/auth', 'AuthController@auth');

    /**
     * Create a user
     */
    Route::post('/user', 'UserController@store');

    /**
     * To use the following resources you must be authenticated with JWT
     */
    Route::group(['middleware' => ['auth.jwt']], function () {

        Route::get('/user', 'UserController@show');

    });

});
