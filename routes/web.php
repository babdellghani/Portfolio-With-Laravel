<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\HomeSlideController;

Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(HomeSlideController::class)->group(function () {
    Route::get('/slide', 'index')->name('home.slide');
    Route::post('/slide', 'store')->name('home.slide.store');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::post('/about', [AboutController::class, 'store'])->name('about.store');

Route::get('/awards', [AwardController::class, 'index'])->name('award');
Route::post('/awards', [AwardController::class, 'store'])->name('award.store');
Route::get('/awards/edit/{award}', [AwardController::class, 'edit'])->name('award.edit');
Route::put('/awards/update/{award}', [AwardController::class, 'update'])->name('award.update');
Route::delete('/awards/delete/{award}', [AwardController::class, 'destroy'])->name('award.destroy');

require __DIR__.'/auth.php';