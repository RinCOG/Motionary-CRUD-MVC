<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\VocabularyWordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dictionary/{word}', [DictionaryController::class, 'show'])->name('dictionary.lookup');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/word-of-the-day', [LearningController::class, 'wordOfTheDay'])->name('word-of-the-day');
Route::get('/grammar', [LearningController::class, 'grammar'])->name('grammar');
Route::get('/slang', [LearningController::class, 'slang'])->name('slang');
Route::get('/games', [LearningController::class, 'games'])->name('games');
Route::get('/camera', [LearningController::class, 'camera'])->name('camera');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('words', VocabularyWordController::class);
});
