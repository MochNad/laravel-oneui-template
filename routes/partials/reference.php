<?php

use App\Http\Controllers\ReferenceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reference', 'as' => 'reference.'], function () {
    Route::get('/icon', [ReferenceController::class, 'icon'])->name('icon');
    Route::get('/menu', [ReferenceController::class, 'menu'])->name('menu');
    Route::get('/role', [ReferenceController::class, 'role'])->name('role');
});
