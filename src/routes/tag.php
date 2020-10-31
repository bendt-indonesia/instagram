<?php

Route::group([
    'prefix' => '/instabt/',
    'namespace' => 'Bendt\Instagram\Controllers',
    'middleware' => ['web']
], function() {
    Route::get('/schedule', 'TagController@schedule')->name('instagram.schedule');
});