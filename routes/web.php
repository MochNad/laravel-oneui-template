<?php

use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;


Route::post('leave-impersonation', [ImpersonateController::class, 'leaveImpersonation'])->name('leave-impersonation');

Route::group(['as' => 'landing.'], function () {
    Route::get('/', [LandingController::class, 'index'])->name('index');
});

require __DIR__ . '/partials/auth.php';

Route::group(['middleware' => ['auth', 'verified']], function () {
    require __DIR__ . '/partials/reference.php';
    require __DIR__ . '/partials/dashboard.php';
    require __DIR__ . '/partials/profile.php';
    require __DIR__ . '/partials/master.php';
    require __DIR__ . '/partials/management.php';
});
