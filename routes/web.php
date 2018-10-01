<?php

require __DIR__ . '/auth.php';

require __DIR__ . '/api.php';

Route::get('/{view}', 'RouterController@show')->where('view', '.*');
