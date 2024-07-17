<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PhotoController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AccountController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AccountController::class, 'register']);
    Route::get('/login', [AccountController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AccountController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/account/edit', [AccountController::class, 'showEditForm'])->name('account.edit');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.delete');
});

Route::get('/', [PhotoController::class, 'index'])->name('photos.index');
Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create')->middleware('auth');
Route::post('/photos/upload', [PhotoController::class, 'upload'])->name('photos.upload')->middleware('auth');
Route::get('/photos/download/{id}', [PhotoController::class, 'download'])->name('photos.download');
Route::post('/photos/favorite/{id}', [PhotoController::class, 'favorite'])->name('photos.favorite')->middleware('auth');