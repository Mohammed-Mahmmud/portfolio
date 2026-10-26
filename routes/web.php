<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::controller(PortfolioController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/archive', 'archive')->name('archive');
    Route::get('/projects/{project:slug}', 'project')->name('projects.show');
    Route::post('/contact', 'contact')->middleware('throttle:5,1')->name('contact');
});
