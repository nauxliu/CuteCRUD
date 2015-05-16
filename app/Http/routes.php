<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::group(['middleware' => ['register.view.variable']], function()
{
    Route::get('models', 'ModelsController@index');
    Route::get('models/create', [
        'as'   => 'models.create',
        'uses' => 'ModelsController@create'
    ]);
});

Route::delete('models/{id}', [
    'as'   => 'models.delete',
    'uses' => 'ModelsController@destroy'
]);