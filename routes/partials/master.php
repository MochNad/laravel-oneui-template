<?php

use App\Http\Controllers\Masters\Authorizations\PermissionController;
use App\Http\Controllers\Masters\Authorizations\RoleController;
use App\Http\Controllers\Masters\MenuController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'authorizations', 'as' => 'authorizations.'], function () {
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('{role}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('{role}/permission', [RoleController::class, 'editPermission'])->name('edit-permission');
        Route::put('{role}/permission', [RoleController::class, 'updatePermission'])->name('update-permission');
    });
    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('{permission}', [PermissionController::class, 'destroy'])->name('destroy');
    });
});
Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('{menu}', [MenuController::class, 'destroy'])->name('destroy');
        Route::put('{menu}/order', [MenuController::class, 'order'])->name('order');
    });
    Route::group(['prefix' => 'landing', 'as' => 'landing.'], function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('{menu}', [MenuController::class, 'destroy'])->name('destroy');
        Route::put('{menu}/order', [MenuController::class, 'order'])->name('order');
    });
});
