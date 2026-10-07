<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::get('/', [PageController::class, 'welcome'])->name('home');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('password.request');
Route::get('/reset-password/{token}', [PageController::class, 'resetPassword'])->name('password.reset');
Route::get('/mentors', [PageController::class, 'mentors'])->name('mentors.index');
Route::get('/mentors/{uuid}', [PageController::class, 'mentorShow'])->name('mentors.show');
Route::get('/categories', [PageController::class, 'categories'])->name('categories.index');
Route::get('/categories/{slug}', [PageController::class, 'categoryShow'])->name('categories.show');
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/mentor', [PageController::class, 'mentorDashboard'])->name('dashboard.mentor');
Route::get('/bookings', [PageController::class, 'bookings'])->name('bookings.index');
Route::post('/logout', [PageController::class, 'logout'])->name('logout');
