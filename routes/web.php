<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});//->middleware(['check_admin']);
//->middleware([\App\Http\Middleware\Admin::class]);

// Route::group()->middleware(['check_admin']);
