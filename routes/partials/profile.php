<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::group(['prefix' => 'update', 'as' => 'update.'], function () {
        Route::put('picture', [ProfileController::class, 'updatePicture'])->name('picture');
        Route::put('banner', [ProfileController::class, 'updateBanner'])->name('banner');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('account');
    });
});
