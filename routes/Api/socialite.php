<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GithubController;

Route::group(
    [
        'middleware' => ['guest'],
        'prefix' => 'github',
        'as' => 'github.',
    ],
    function () {
        Route::get('/sign-in', [GithubController::class, 'sign'])->name('sign');
        Route::get('/sign-in/redirect', [GithubController::class, 'redirect'])->name('redirect');
    }
);
