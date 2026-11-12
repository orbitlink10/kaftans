<?php

use App\Http\Controllers\Admin\HomepageContentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/storefront.php';

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/mpesa/callback', [PaymentController::class, 'callback'])->name('mpesa.callback');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::post('/bookings/{booking}/payments/mpesa', [PaymentController::class, 'initiate'])->name('payments.mpesa');
    Route::post('/bookings/{booking}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::middleware('role:provider')->group(function () {
        Route::patch('/provider/jobs/{booking}', [AssignmentController::class, 'providerAction'])->name('provider.jobs.update');
    });

    Route::middleware('role:admin,dispatcher')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('providers', ProviderController::class)->except(['show']);
        Route::get('/homepage-content', [HomepageContentController::class, 'edit'])->name('homepage.edit');
        Route::put('/homepage-content', [HomepageContentController::class, 'update'])->name('homepage.update');
        Route::get('/bookings/{booking}/assign', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::patch('/bookings/{booking}/assign', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

    Route::middleware('role:admin,dispatcher')->name('admin.')->group(function () {
        Route::get('/pages', [PageController::class, 'index'])->name('pages');
        Route::get('/new-post', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->whereNumber('id')->name('pages.edit');
        Route::put('/pages/{id}', [PageController::class, 'update'])->whereNumber('id')->name('pages.update');
        Route::delete('/pages/{id}', [PageController::class, 'destroy'])->whereNumber('id')->name('pages.destroy');
    });
});

Route::get('/page/{slug}', fn (string $slug) => redirect('/'.$slug, 301));
Route::get('/page-images/{path}', [PageController::class, 'image'])
    ->where('path', '.*')
    ->name('pages.image');
Route::get('/{slug}', function (string $slug) {
    abort_unless(auth()->check() && auth()->user()->isRole(['admin', 'dispatcher']), 404);

    return app(PageController::class)->preview($slug);
})
    ->where('slug', '^(?!admin|bookings|dashboard|forgot-password|login|logout|new-post|page|pages|password|profile|register|storage).+')
    ->name('pages.preview');
