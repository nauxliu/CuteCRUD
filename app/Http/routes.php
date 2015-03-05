<?php

Route::get ('/','CRUDController@index');
Route::get ('crud','CRUDController@index');
Route::get ('crud/create','CRUDController@create');
Route::post('crud/create','CRUDController@store');
Route::get ('crud/delete/{id}','CRUDController@delete');
Route::get ('crud/edit/{id}','CRUDController@edit');
Route::post('crud/update/{id}','CRUDController@update');
Route::get ('crud/all','CRUDController@index');

Route::get ('table/{table_name}/settings','SettingsController@settings');
Route::post('table/{table_name}/settings','SettingsController@postSettings');

Route::get ('table/{table_name}/create','TablesController@create');
Route::post('table/{table_name}/create','TablesController@store');
Route::get ('table/{table_name}/list','TablesController@all');
Route::get ('table/{table_name}/delete/{id}','TablesController@delete');
Route::get ('table/{table_name}/edit/{id}','TablesController@edit');
Route::post('table/{table_name}/update/{id}','TablesController@update');