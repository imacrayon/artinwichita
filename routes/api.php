<?php

Route::prefix('api')->namespace('Api')->group(function () {
    Route::get('/import/facebook', 'ImportController@facebook')->name('import.facebook');
});
