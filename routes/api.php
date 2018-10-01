<?php

Route::prefix('api')->namespace('Api')->name('api.')->group(function () {
    Route::get('/import/facebook', 'ImportController@facebook')->name('import.facebook');

    Route::resource('/events', 'EventController', ['except' => ['create', 'edit']]);

    Route::get('/places', 'PlaceController@index')->name('places.index');
});
