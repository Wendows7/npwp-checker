<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\LoginController::class, 'index'])->name('auth.login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('auth.authenticate');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/suspect', [\App\Http\Controllers\SuspectController::class, 'index'])->name('suspect');
    Route::get('/suspect/search', [\App\Http\Controllers\SuspectController::class, 'search'])->name('suspect.search');

    Route::middleware('can:superadmin')->group(function () {
        Route::get('/data/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
        Route::delete('/data/users/delete', [\App\Http\Controllers\UserController::class, 'deleteById'])->name('users.delete');
        Route::post('/data/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::put('/data/users/update', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    });

    Route::middleware('can:data-suspect')->group(function () {
        Route::get('/data/suspects', [\App\Http\Controllers\SuspectController::class, 'getAll'])->name('suspects.all');
        Route::post('/data/suspect/import', [\App\Http\Controllers\SuspectController::class, 'import'])->name('suspect.import');
        Route::post('/data/suspect/store', [\App\Http\Controllers\SuspectController::class, 'store'])->name('suspect.store');
        Route::put('/data/suspect/update/{suspect}', [\App\Http\Controllers\SuspectController::class, 'update'])->name('suspect.update');
        Route::delete('/data/suspect/delete/{suspect}', [\App\Http\Controllers\SuspectController::class, 'delete'])->name('suspect.delete');
    });
});




