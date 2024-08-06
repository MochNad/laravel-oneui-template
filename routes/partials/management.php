<?php

use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\Managements\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{user}', [UserController::class, 'update'])->name('update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('{user}/reset', [UserController::class, 'reset'])->name('reset');
    Route::post('{user}/impersonate', [ImpersonateController::class, 'impersonate'])->name('impersonate');
});
