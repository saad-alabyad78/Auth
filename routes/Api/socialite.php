<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProviderController;

Route::group(
    [
        'middleware' => ['guest'],
        'prefix' => 'provider',
        'as' => 'provider.',
    ],
    function () {
        Route::get('/{provider}/sign-in/redirect', [ProviderController::class, 'redirect'])->name('redirect');
        Route::get('/{provider}/sign-in/callback', [ProviderController::class, 'callback'])->name('callback');
    }
);
