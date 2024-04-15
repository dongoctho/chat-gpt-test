<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpenAiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(csrf_token());
    return view('welcome');

});
// Route::resource('/chatgpt',OpenAiController::class);
Route::get('/chatgpt', [HomeController::class,'index']);
Route::post('/chatgpt/create', [HomeController::class,'createRequest']);
