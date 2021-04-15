<?php

use Illuminate\Support\Facades\Route;



Route::get('/', 'MainController@index');

Auth::routes();

