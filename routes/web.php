<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\About\AboutController;
use App\Http\Controllers\About\AwardController;
use App\Http\Controllers\About\SkillController;
use App\Http\Controllers\Home\HomeSlideController;
use App\Http\Controllers\About\EducationController;

// -------------- Frontend --------------- //
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::get('/about', function() {
    return view('frontend.pages.about');
})->name('about');

Route::get('/services', [ServiceController::class, 'home'])->name('services');
Route::get('/services/{service:slug}', [ServiceController::class, 'details'])->name('services.details');

Route::get('/portfolio', [PortfolioController::class, 'home'])->name('portfolio');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'details'])->name('portfolio.details');

// -------------- Admin --------------- //
Route::prefix('/admin')->group(function () {
    // dashboard
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // profile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ---- home ---- //
    // home slide
    Route::controller(HomeSlideController::class)->group(function () {
        Route::get('/slide', 'index')->name('home.slide');
        Route::post('/slide', 'store')->name('home.slide.store');
    });

    // ---- about ---- //
    // about
    Route::get('/about', [AboutController::class, 'index'])->name('admin.about');
    Route::post('/about', [AboutController::class, 'store'])->name('about.store');

    // awards
    Route::get('/awards', [AwardController::class, 'index'])->name('award');
    Route::post('/awards', [AwardController::class, 'store'])->name('award.store');
    Route::get('/awards/edit/{award}', [AwardController::class, 'edit'])->name('award.edit');
    Route::put('/awards/update/{award}', [AwardController::class, 'update'])->name('award.update');
    Route::delete('/awards/delete/{award}', [AwardController::class, 'destroy'])->name('award.destroy');

    // education
    Route::get('/educations', [EducationController::class, 'index'])->name('education');
    Route::post('/educations', [EducationController::class, 'store'])->name('education.store');
    Route::get('/educations/edit/{education}', [EducationController::class, 'edit'])->name('education.edit');
    Route::put('/educations/update/{education}', [EducationController::class, 'update'])->name('education.update');
    Route::delete('/educations/delete/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    // skills
    Route::get('/skills', [SkillController::class, 'index'])->name('skill');
    Route::post('/skills', [SkillController::class, 'store'])->name('skill.store');
    Route::get('/skills/edit/{skill}', [SkillController::class, 'edit'])->name('skill.edit');
    Route::put('/skills/update/{skill}', [SkillController::class, 'update'])->name('skill.update');
    Route::delete('/skills/delete/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');

    // service
    Route::get('/services', [ServiceController::class, 'index'])->name('service');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/services/edit/{service}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/services/update/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/services/delete/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

    // portfolio
    Route::get('/portfolios', [\App\Http\Controllers\PortfolioController::class, 'index'])->name('portfolio');
    Route::post('/portfolios', [\App\Http\Controllers\PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolios/edit/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolios/update/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'update'])->name('portfolio.update');
    Route::patch('/portfolios/status/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'status'])->name('portfolio.status');
    Route::delete('/portfolios/delete/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'destroy'])->name('portfolio.destroy');
});

require __DIR__ . '/auth.php';