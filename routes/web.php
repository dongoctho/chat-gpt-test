<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpenAiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dd(csrf_token(),cookie());
    return view('welcome');

});
// Route::resource('/chatgpt',OpenAiController::class);
Route::get('/', [HomeController::class,'index'])->name('chatgpt.index');
Route::post('/chatgpt/create/', [HomeController::class,'createRequest'])->name('chatgpt.create');
Route::get('/list', [HomeController::class,'list'])->name('chatgpt.index');
Route::get('/edit/{id}', [HomeController::class,'edit'])->name('chatgpt.edit');
Route::post('/chatgpt/create/continue', [HomeController::class,'continueChat'])->name('chatgpt.create.continue');
