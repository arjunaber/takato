<?php

use App\Http\Controllers\GrandScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;


Route::get('/', function () {
    return view('welcome');
});

//landing routenya views>auth>landing>index.blade.php
Route::get('/landing', function () {
    return view('auth.landing.index');
});

//route views>auth>grandschedule>index.blade.php tanpa controller
Route::get('/grandschedule', function () {
    return view('auth.grandschedule.index');
});
