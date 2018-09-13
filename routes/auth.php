<?php

Auth::routes(['verify' => true]);
Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('auth.social');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
