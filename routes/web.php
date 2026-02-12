<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/admin/login');

Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // Registration Routes
    Route::get('/register', [App\Http\Controllers\Admin\AuthController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [App\Http\Controllers\Admin\AuthController::class, 'register']);

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // User Management Routes
        Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

        // Email Template Management Routes
        Route::resource('email-templates', App\Http\Controllers\Admin\EmailTemplateController::class)->names('admin.email_templates');
    });
});