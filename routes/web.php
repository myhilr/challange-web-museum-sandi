<?php

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/category/{id}', [LandingController::class, 'category'])->name('news.category');
