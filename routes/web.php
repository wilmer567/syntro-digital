<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FirebaseController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PrincipleController;
use App\Http\Controllers\Admin\ProcessStepController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])
    ->middleware('throttle:admin-login')
    ->name('login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // General & Hero Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services/header', [ServiceController::class, 'updateHeader'])->name('services.header');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // About / Mission / Vision
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::post('/about', [AboutController::class, 'update'])->name('about.update');

    // Principles
    Route::get('/principles', [PrincipleController::class, 'index'])->name('principles.index');
    Route::post('/principles/header', [PrincipleController::class, 'updateHeader'])->name('principles.header');
    Route::post('/principles', [PrincipleController::class, 'store'])->name('principles.store');
    Route::put('/principles/{principle}', [PrincipleController::class, 'update'])->name('principles.update');
    Route::delete('/principles/{principle}', [PrincipleController::class, 'destroy'])->name('principles.destroy');

    // Process Steps
    Route::get('/process', [ProcessStepController::class, 'index'])->name('process.index');
    Route::post('/process/header', [ProcessStepController::class, 'updateHeader'])->name('process.header');
    Route::post('/process', [ProcessStepController::class, 'store'])->name('process.store');
    Route::put('/process/{step}', [ProcessStepController::class, 'update'])->name('process.update');
    Route::delete('/process/{step}', [ProcessStepController::class, 'destroy'])->name('process.destroy');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects/header', [ProjectController::class, 'updateHeader'])->name('projects.header');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Contact Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('messages.toggleRead');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Profile & Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Firebase Cloud Sync
    Route::post('/firebase/sync', [FirebaseController::class, 'sync'])
        ->middleware('throttle:firebase-admin')
        ->name('firebase.sync');
    Route::get('/firebase/test', [FirebaseController::class, 'test'])
        ->middleware('throttle:firebase-admin')
        ->name('firebase.test');
});
