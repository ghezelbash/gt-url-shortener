<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    //Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //URL Management routes
    Route::get('/dashboard', [UrlController::class, 'index'])->name('dashboard');
    Route::post('/urls', [UrlController::class, 'store'])->name('urls.store');
    Route::put('/urls/{uuid}', [UrlController::class, 'update'])->name('urls.update');
    Route::delete('/urls/{uuid}', [UrlController::class, 'destroy'])->name('urls.destroy');
});

//Redirection route
Route::get('/{shortenedUrl}', [UrlController::class, 'redirect']);
